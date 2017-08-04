

<!-- toc -->

- [CakePHP Sample App on OpenShift](#cakephp-sample-app-on-openshift)
  * [OpenShift Considerations](#openshift-considerations)
    + [Security](#security)
    + [Installation:](#installation)
    + [Debugging Unexpected Failures](#debugging-unexpected-failures)
    + [Installation: With MySQL](#installation-with-mysql)
    + [Adding Webhooks and Making Code Changes](#adding-webhooks-and-making-code-changes)
    + [Enabling the Database example](#enabling-the-database-example)
    + [Hot Deploy](#hot-deploy)
    + [Source repository layout](#source-repository-layout)
    + [Compatibility](#compatibility)
    + [License](#license)

<!-- tocstop -->

CakePHP Sample App on OpenShift
===============================

This is a quickstart CakePHP application for OpenShift v3 that you can use as a starting point to develop your own application and deploy it on an [OpenShift](https://github.com/openshift/origin) cluster.

If you'd like to install it, follow [these directions](https://github.com/openshift/cakephp-ex/blob/master/README.md#installation).  

The steps in this document assume that you have access to an OpenShift deployment that you can deploy applications on.

OpenShift Considerations
------------------------
These are some special considerations you may need to keep in mind when running your application on OpenShift.

### Security
Since the quickstarts are shared code, we had to take special consideration to ensure that security related configuration variable values are unique across applications. To accomplish this, we modified some of the configuration files. Namely we changed Security.salt and Security.cipherSeed values in the app/Config/core.php config file. Those values are now generated from the application template as CAKEPHP_SECURITY_SALT and CAKEPHP_SECURITY_CIPHER_SEED. Also the secret token is generated in the template as CAKEPHP_SECRET_TOKEN. From these values the session hashes are generated. Now instead of using the same default values, OpenShift can generate these values using the generate from logic defined within the instant application's template.

### Installation:
These steps assume your OpenShift deployment has the default set of ImageStreams defined.  Instructions for installing the default ImageStreams are available [here](https://docs.openshift.org/latest/install_config/imagestreams_templates.html#creating-image-streams-for-openshift-images).  If you are defining the set of ImageStreams now, remember to pass in the proper cluster-admin credentials and to create the ImageStreams in the 'openshift' namespace.

1. Fork a copy of [cakephp-ex](https://github.com/openshift/cakephp-ex)
2. Clone your repository to your development machine and cd to the repository directory
3. Add a PHP application from the provided template and specify the source url to be your forked repo  

		$ oc new-app openshift/templates/cakephp.json -p SOURCE_REPOSITORY_URL=<your repository location>

4. Depending on the state of your system, and whether additional items need to be downloaded, it may take around a minute for your build to be started automatically.  If you do not want to wait, run

		$ oc start-build cakephp-example

5. Once the build is running, watch your build progress  

		$ oc logs build/cakephp-example-1

6. Wait for cakephp-example pods to start up (this can take a few minutes):  

		$ oc get pods -w


	Sample output:  

	       NAME                      READY     REASON         RESTARTS   AGE
	       cakephp-example-1-build   0/1       ExitCode:0     0          8m
	       cakephp-example-1-pytud   1/1       Running        0          2m


7. Check the IP and port the cakephp-example service is running on:  

		$ oc get svc

	Sample output:  

	       NAME              LABELS                     SELECTOR               IP(S)           PORT(S)
	       cakephp-example   template=cakephp-example   name=cakephp-example   172.30.97.123   8080/TCP

In this case, the IP for cakephp-example is 172.30.97.123 and it is on port 8080.  
*Note*: you can also get this information from the web console.

### Debugging Unexpected Failures

Review some of the common tips and suggestions [here](https://github.com/openshift/origin/blob/master/docs/debugging-openshift.md).

### Installation: With MySQL
1. Follow the steps for the Manual Installation above for all but step 3, instead use step 2 below.  
  - Note: The output in steps 5-6 may also display information about your database.
2. Add a PHP application from the cakephp-mysql template and specify the source url to be your forked repo  

		$ oc new-app openshift/templates/cakephp-mysql.json -p SOURCE_REPOSITORY_URL=<your repository location>


### Adding Webhooks and Making Code Changes
Since OpenShift V3 does not provide a git repository out of the box, you can configure your github repository to make a webhook call whenever you push your code.

1. From the Web Console homepage, navigate to your project
2. Click on Browse > Builds
3. Click the link with your BuildConfig name
4. Click the Configuration tab
5. Click the "Copy to clipboard" icon to the right of the "GitHub webhook URL" field
6. Navigate to your repository on GitHub and click on repository settings > webhooks > Add webhook
7. Paste your webhook URL provided by OpenShift
8. Leave the defaults for the remaining fields - That's it!
9. After you save your webhook, if you refresh your settings page you can see the status of the ping that Github sent to OpenShift to verify it can reach the server.  

### Enabling the Database example
In order to access the example CakePHP home page, which contains application stats including database connectivity, you have to go into the app/View/Layouts/ directory, remove the default.ctp and after that rename default.ctp.default into default.ctp`.

It will also be necessary to update your application to talk to your database back-end. The app/Config/database.php file used by CakePHP was set up in such a way that it will accept environment variables for your connection information that you pass to it. Once an administrator has created a MySQL database service for you to connect with you can add the following environment variables to your deploymentConfig to ensure all your cakephp-example pods have access to these environment variables. Note: the cakephp-mysql.json template creates the DB service and environment variables for you.

You will then need to rebuild the application.  This is done via either a `oc start-build` command, or through the web console, or a webhook trigger in github initiating a build after the code changes are pushed.

### Hot Deploy

In order to immediately pick up changes made in your application source code, you need to run your built image with the `OPCACHE_REVALIDATE_FREQ=0` parameter to the [oc new-app](https://docs.openshift.org/latest/cli_reference/basic_cli_operations.html#basic-cli-operations) command, while performing the [installation steps](https://github.com/openshift/cakephp-ex#installation) described in this README.

	$ oc new-app openshift/templates/cakephp-mysql.json -p OPCACHE_REVALIDATE_FREQ=0

Hot deploy works out of the box in the php image used with this example.

To change your source code in the running container you need to [oc rsh](https://docs.openshift.org/latest/cli_reference/basic_cli_operations.html#troubleshooting-and-debugging-cli-operations) into it.

	$ oc rsh <POD_ID>

After you [oc rsh](https://docs.openshift.org/latest/cli_reference/basic_cli_operations.html#troubleshooting-and-debugging-cli-operations) into the running container, your current directory is set to `/opt/app-root/src`, where the source code is located.

### Source repository layout

You do not need to change anything in your existing PHP project's repository.
However, if these files exist they will affect the behavior of the build process:

* **composer.json**

  List of dependencies to be installed with `composer`. The format is documented
  [here](https://getcomposer.org/doc/04-schema.md).

### Compatibility

This repository is compatible with PHP 5.6 and higher, excluding any alpha or beta versions.

### License
This code is dedicated to the public domain to the maximum extent permitted by applicable law, pursuant to [CC0](http://creativecommons.org/publicdomain/zero/1.0/).
