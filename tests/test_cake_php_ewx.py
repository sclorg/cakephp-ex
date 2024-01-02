import os

import pytest

from container_ci_suite.openshift import OpenShiftAPI

test_dir = os.path.abspath(os.path.dirname(__file__))

CAKEPHP = OpenShiftAPI.get_raw_url_for_json(container="cakephp-ex", dir="openshift/templates", filename="cakephp.json")
CAKEPHP_MYSQL_PERSISTENT = OpenShiftAPI.get_raw_url_for_json(container="cakephp-ex", dir="openshift/templates", filename="cakephp-mysql-persistent.json")
IS_PHP = OpenShiftAPI.get_raw_url_for_json(container="s2i-php-container", dir="imagestreams", filename="php-rhel.json")

@pytest.fixture
def get_version():
    return os.environ.get("SINGLE_VERSION")


class TestCakePHPEx:
    def setup_method(self):
        self.oc_api = OpenShiftAPI(namespace="cake-php-ex-tests")

# -p SOURCE_REPOSITORY_REF=master -p SOURCE_REPOSITORY_URL=https://github.com/sclorg/cakephp-ex.git -p PHP_VERSION=8.0-ubi8 -p NAME=php-testing
    def test_deployment_template(self):
        self.oc_api.import_is(path=IS_PHP, name="php")
        assert self.oc_api.check_is_exists(is_name="php", version_to_check="8.0-ubi8")
        #self.oc_api.process_file(path=TEMPLATE_RAILS_POSTGRESQL, name="rails-postgresql-example")
        self.oc_api.create_new_app_with_template(template_json=CAKEPHP, github_repo="https://github.com/sclorg/cakephp-ex")
        self.oc_api.is_pod_ready(pod_name="cakephp-ex")
        # self.oc_api.ct_os_check_service_image_info()
