import os

import pytest
from pathlib import Path

from container_ci_suite.openshift import OpenShiftAPI

test_dir = Path(os.path.abspath(os.path.dirname(__file__)))

VERSION = os.getenv("SINGLE_VERSION")
if not VERSION:
	VERSION = "8.1-ubi8"


class TestCakePHPAppExTemplate:

	def setup_method(self):
		self.oc_api = OpenShiftAPI(pod_name_prefix="cakephp-example")
		json_raw_file = self.oc_api.get_raw_url_for_json(container="s2i-php-container", dir="imagestreams",
														 filename="php-rhel.json")
		self.oc_api.import_is(path=json_raw_file, name="php")

	def teardown_method(self):
		self.oc_api.delete_project()

	def test_template_inside_cluster(self):
		branch_to_test = "master"
		expected_output = "Welcome to PHP"
		if VERSION.startswith("7.4") or VERSION.startswith("8.0"):
			branch_to_test = "4.X"
			expected_output = "Welcome to CakePHP 4"
		if VERSION.startswith("8.1") or VERSION.startswith("8.2"):
			branch_to_test = "5.X"
			expected_output = "Welcome to CakePHP 5"

		template_json = self.oc_api.get_raw_url_for_json(
			container="cakephp-ex", branch=branch_to_test, dir="openshift/templates", filename="cakephp.json"
		)
		assert self.oc_api.deploy_template(
			template=template_json, name_in_template="cakephp-example", expected_output=expected_output,
			openshift_args=[f"SOURCE_REPOSITORY_REF={branch_to_test}", f"PHP_VERSION={VERSION}", "NAME=cakephp-example"]
		)
		assert self.oc_api.template_deployed(name_in_template="cakephp-example")
		assert self.oc_api.check_response_inside_cluster(
			name_in_template="cakephp-example", expected_output=expected_output
		)

	def test_template_by_request(self):
		branch_to_test = "master"
		expected_output = "Welcome to PHP"
		if VERSION.startswith("7.4") or VERSION.startswith("8.0"):
			branch_to_test = "4.X"
			expected_output = "Welcome to CakePHP 4"
		elif VERSION.startswith("8.1") or VERSION.startswith("8.2"):
			branch_to_test = "5.X"
			expected_output = "Welcome to CakePHP 5"

		template_json = self.oc_api.get_raw_url_for_json(
			container="cakephp-ex", branch=branch_to_test, dir="openshift/templates", filename="cakephp.json"
		)
		assert self.oc_api.deploy_template(
			template=template_json, name_in_template="cakephp-example", expected_output=expected_output,
			openshift_args=[f"SOURCE_REPOSITORY_REF={branch_to_test}", f"PHP_VERSION={VERSION}", "NAME=cakephp-example"]
		)
		assert self.oc_api.template_deployed(name_in_template="cakephp-example")
		assert self.oc_api.check_response_outside_cluster(
			protocol="https",
			name_in_template="cakephp-example", expected_output=expected_output
		)
