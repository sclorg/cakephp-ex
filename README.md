CakePHP Sample App on OpenShift
-----------------

This example will serve an http response of various "machine" stats from the "machine" the CakePHP app is running on to [http://host:8080](http://host:8080).

### OpenShift setup ###

One possible option is to use the Docker all-in-one launch as described in the [origins project](https://github.com/openshift/origins).

### The project ###

If you don't have a project setup all ready, go ahead and take care of that

        $ osc new-project cakephp --display-name="CakePHP" --description="Sample CakePHP app"

That's it, project has been created.  Though it would probably be good to set your current project to this (thought new-project does it automatically as well), such as:

        $ osc project cakephp

### The app ###

Now let's pull in the app source code from [GitHub repo](https://github.com/openshift/cakephp-ex) (fork if you like)

#### create ####

        $ osc new-app https://github.com/openshift/cakephp-ex
        
That should be it, `new-app` will take care of creating the right build configuration, deployment configuration and service definition.  Next you'll be able to kick off the build.

Note, you can follow along with the web console (located at https://ip-address:8443/console) to see what new resources have been created and watch the progress of the build and deployment.

#### build ####

        $ osc start-build cakephp-example-1 --follow

You can alternatively leave off `--follow` and use `osc build-logs cakephp-example-1` where n is the number of the build (output of start-build).

#### deploy ####

happens automatically, to monitor its status either watch the web console or `osc get pods` to see when the pod is up.  Another helpful command is

        $ osc status

This will help indicate what IP address the service is running, the default port for it to deploy at is 8080.  

#### enjoy ####

Run/test our app by simply doing an HTTP GET request

        $ curl ip-address:8080

#### update ####

Assuming you used the URL of your own forked report, we can easily push changes to that hosted repo and simply repeat the steps above to build (this is obviously just demonstrating the manually kicking off of builds) which will trigger the new built image to be deployed.

#### delete ####

		$ oc delete all --all

To remove all the resources created for you application.