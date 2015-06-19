CakePHP Sample App on OpenShift
===============================

This is a quickstart CakePHP application for OpenShift v3 that you can use as a starting point to develop your own application and deploy it on an [OpenShift](https://github.com/openshift/origin) cluster.

If you'd like to install it, follow [these directions](https://github.com/openshift/cakephp-ex/blob/master/README.md#installation).  

The steps in this document assume that you have access to an OpenShift deployment that you can deploy applications on.

OpenShift Considerations
------------------------
These are some special considerations you may need to keep in mind when running your application on OpenShift.

###Security
Since the quickstarts are shared code, we had to take special consideration to ensure that security related configuration variable values are unique across applications. To accomplish this, we modified some of the configuration files. Namely we changed Security.salt and Security.cipherSeed values in the app/Config/core.php config file. Those values are now generated from the application template as CAKEPHP_SECURITY_SALT and CAKEPHP_SECURITY_CIPHER_SEED. Also the secret token is generated in the template as CAKEPHP_SECRET_TOKEN. From these values the session hashes are generated. Now instead of using the same default values, OpenShift can generate these values using the generate from logic defined within the instant application's template.

###Installation: 
These steps assume your OpenShift deployment has the default set of ImageStreams defined.  Instructions for installing the default ImageStreams are available [here](http://docs.openshift.org/latest/admin_guide/install/first_steps.html)

1. Fork a copy of [cakephp-ex](https://github.com/openshift/cakephp-ex)
2. Clone your repository to your development machine and cd to the repository directory
3. Add a PHP application from the provided template and specify the source url to be your forked repo  

		$ oc process -f openshift/templates/cakephp.json -v SOURCE_REPOSITORY_URL=<your repository location> | oc create -f - 

4. Watch your build progress  

		$ oc build-logs cakephp-app-1

5. Wait for frontend pods to start up (this can take a few minutes):  

		$ oc get pods -w


	Sample output:  

		NAME                       READY     REASON    RESTARTS   AGE
		cakephp-example-1-build     1/1       Running   0          4m
		cakephp-frontend-1-deploy   1/1       Running   0          4s
		cakephp-frontend-1-votfl    0/1       Pending   0          1s
		NAME                     READY     REASON       RESTARTS   AGE
		cakephp-example-1-build   0/1       ExitCode:0   0          4m
		cakephp-frontend-1-votfl   0/1       Running   0         6s
		cakephp-frontend-1-deploy   0/1       ExitCode:0   0         14s
		cakephp-frontend-1-votfl   1/1       Running   0         12s    


6. Check the IP and port the frontend service is running on:  

		$ oc get svc

	Sample output:  

		NAME              LABELS                          SELECTOR               IP(S)            PORT(S)
		cakephp-frontend   template=cakephp-mysql-example   name=cakephp-frontend   172.30.174.142   8080/TCP

In this case, the IP for frontend is 172.30.174.142 and it is on port 8080.  
*Note*: you can also get this information from the web console.

###Installation: With MySQL
1. Follow the steps for the Manual Installation above for all but step 3, instead use step 2 below.  
  - Note: The output in steps 5-6 may also display information about your database.
2. Add a PHP application from the cakephp-mysql template and specify the source url to be your forked repo  

		$ oc process -f openshift/templates/cakephp-mysql.json -v SOURCE_REPOSITORY_URL=<your repository location> | oc create -f - 


###Adding Webhooks and Making Code Changes
Since OpenShift V3 does not provide a git repository out of the box, you can configure your github repository to make a webhook call whenever you push your code.

1. From the console navigate to your project  
2. Click on Browse > Builds  
3. From the view for your Build click on the link to display your GitHub webhook and copy the url.  
4. Navigate to your repository on GitHub and click on repository settings > webhooks  
5. Paste your copied webhook url provided by OpenShift - Thats it!  
6. After you save your webhook, if you refresh your settings page you can see the status of the ping that Github sent to OpenShift to verify it can reach the server.  

###Enabling the Database example
In order to access the example CakePHP home page, which contains application stats including database connectivity, you have to go into the app/Views/Layouts/ directory, remove the default.ctp and after that rename default.ctp.default into default.ctp`.

You will then need to rebuild the application.

###License
This code is dedicated to the public domain to the maximum extent permitted by applicable law, pursuant to [CC0](http://creativecommons.org/publicdomain/zero/1.0/).