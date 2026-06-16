import os
import pytest

from pathlib import Path

from container_ci_suite.openshift import OpenShiftAPI

from constants import TAGS, is_test_allowed

test_dir = Path(os.path.abspath(os.path.dirname(__file__)))

VERSION = os.getenv("SINGLE_VERSION")
OS = os.getenv("OS")
PR_NUMBER = os.getenv("PR_NUMBER")

TAG = TAGS.get(OS)


class TestCakePHPAppExTemplate:
    def setup_method(self):
        self.oc_api = OpenShiftAPI(pod_name_prefix="cakephp-example", shared_cluster=True)
        json_raw_file = self.oc_api.get_raw_url_for_json(
            container="s2i-php-container", dir="imagestreams", filename="php-rhel.json"
        )
        self.oc_api.import_is(path=json_raw_file, name="php", skip_check=True)

    def teardown_method(self):
        self.oc_api.delete_project()

    def test_local_template_inside_cluster(self):
        if not is_test_allowed(OS, VERSION):
            pytest.skip(f"Local templates are not supported for {OS} and {VERSION}")
        expected_output = "Welcome to CakePHP"
        template_json = "../openshift/templates/cakephp.json"
        assert self.oc_api.deploy_template(
            template=template_json,
            name_in_template="cakephp-example",
            expected_output=expected_output,
            openshift_args=[
                f"SOURCE_REPOSITORY_REF=refs/pull/{PR_NUMBER}/head",
                f"PHP_VERSION={VERSION}{TAG}",
                "NAME=cakephp-example",
            ],
        )
        assert self.oc_api.is_template_deployed(name_in_template="cakephp-example", timeout=600)
        assert self.oc_api.check_response_inside_cluster(
            name_in_template="cakephp-example", expected_output=expected_output
        )

    def test_remote_template_inside_cluster(self):
        if not is_test_allowed(OS, VERSION):
            pytest.skip(f"Remote templates are not supported for {OS} and {VERSION}")
        expected_output = "Welcome to CakePHP"
        template_json = self.oc_api.get_raw_url_for_json(
            container="cakephp-ex", dir="openshift/templates", filename="cakephp.json"
        )
        assert self.oc_api.deploy_template(
            template=template_json,
            name_in_template="cakephp-example",
            expected_output=expected_output,
            openshift_args=[
                f"SOURCE_REPOSITORY_REF=refs/pull/{PR_NUMBER}/head",
                f"PHP_VERSION={VERSION}{TAG}",
                "NAME=cakephp-example",
            ],
        )
        assert self.oc_api.is_template_deployed(name_in_template="cakephp-example", timeout=600)
        assert self.oc_api.check_response_inside_cluster(
            name_in_template="cakephp-example", expected_output=expected_output
        )
