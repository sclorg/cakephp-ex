        <div class="row">
          <section class='col-xs-12 col-sm-6 col-md-6'>
            <section>
              <h2>How to use this example application</h2>
                <p>For instructions on how to use this application with OpenShift, start by reading the <a href="http://docs.okd.io/latest/dev_guide/templates.html#using-the-quickstart-templates">Developer Guide</a>.</p>

              <h2>Deploying code changes</h2>
                <p>
                  The source code for this application is available to be forked from the <a href="https://www.github.com/sclorg/cakephp-ex">OpenShift GitHub repository</a>.
                  You can configure a webhook in your repository to make OpenShift automatically start a build whenever you push your code:
                </p>

<ol>
  <li>From the Web Console homepage, navigate to your project</li>
  <li>Click on Browse &gt; Builds</li>
  <li>Click the link with your BuildConfig name</li>
  <li>Click the Configuration tab</li>
  <li>Click the "Copy to clipboard" icon to the right of the "GitHub webhook URL" field</li>
  <li>Navigate to your repository on GitHub and click on repository settings &gt; webhooks &gt; Add webhook</li>
  <li>Paste your webhook URL provided by OpenShift</li>
  <li>Leave the defaults for the remaining fields &mdash; that's it!</li>
</ol>
<p>After you save your webhook, if you refresh your settings page you can see the status of the ping that Github sent to OpenShift to verify it can reach the server.</p>
<p>Note: adding a webhook requires your OpenShift server to be reachable from GitHub.</p>

                <h3>Working in your local Git repository</h3>
                <p>If you forked the application from the OpenShift GitHub example, you'll need to manually clone the repository to your local system. Copy the application's source code Git URL and then run:</p>

<pre>$ git clone &lt;git_url&gt; &lt;directory_to_create&gt;

# Within your project directory
# Commit your changes and push to OpenShift

$ git commit -a -m 'Some commit message'
$ git push</pre>

<p>After pushing changes, you'll need to manually trigger a build if you did not setup a webhook as described above.</p>

                  <h3>Expanding on sample app</h3>
                  <p>
                  In order to access the original CakePHP application, you must restore the original
                  src/Template/Layout/default.ctp.default and src/Template/Pages/home.ctp.default files.
                  </p>
                  <p>
                  It will also be necessary to update your application to talk to your database back-end.  The <code>config/app.php</code> file used by CakePHP was set up in such a way that it will accept environment variables for your connection information that you pass to it.
                  Once an administrator has created a MySQL database service for you to connect with you can add the following environment variables to your deploymentConfig to ensure all your frontend pods have access to these environment variables.
                  Note: the cakephp-mysql.json template creates the DB service and environment variables for you.

<pre>
oc env dc/cakephp-mysql-example DATABASE_SERVICE_NAME=&lt;database service name&gt;
oc env dc/cakephp-mysql-example DATABASE_ENGINE=mysql
oc env dc/cakephp-mysql-example DATABASE_NAME=&lt;your created database&gt;
oc env dc/cakephp-mysql-example &lt;database service name&gt;_DATABASE_USER=&lt;your database user&gt;
oc env dc/cakephp-mysql-example &lt;database service name&gt;_DATABASE_PASSWORD=&lt;your database user's password&gt;
</pre>
                  </p>
                  <p>
                  Note: If the database service is created in the same project as the frontend pod,
                  the *_SERVICE_HOST and *_SERVICE_PORT environment variables will be automatically
                  created.
                  </p>
                  <p>
                  You will need to redeploy your application in order to pick up the new environment variables.  You can force a deployment
                  by running:
<pre>
oc deploy cakephp-mysql-example --latest
</pre>
                  </p>

            </section>

          </section>
          <section class="col-xs-12 col-sm-6 col-md-6">

                <h2>Managing your application</h2>

                <p>Documentation on how to manage your application from the Web Console or Command Line is available at the <a href="http://docs.okd.io/latest/dev_guide/overview.html">Developer Guide</a>.</p>

                <h3>Web Console</h3>
                <p>You can use the Web Console to view the state of your application components and launch new builds.</p>

                <h3>Command Line</h3>
                <p>With the <a href="http://docs.okd.io/latest/cli_reference/overview.html">OpenShift command line interface</a> (CLI), you can create applications and manage projects from a terminal.</p>

                <h2>Development Resources</h2>
                  <ul>
                    <li><a href="http://docs.okd.io/latest/welcome/index.html">OpenShift Documentation</a></li>
                    <li><a href="https://github.com/openshift/origin">Openshift Origin GitHub</a></li>
                    <li><a href="https://github.com/openshift/source-to-image">Source To Image GitHub</a></li>
                    <li><a href="http://docs.okd.io/latest/using_images/s2i_images/php.html">Getting Started with PHP on OpenShift</a></li>
                    <li><a href="http://stackoverflow.com/questions/tagged/openshift">Stack Overflow questions for OpenShift</a></li>
                    <li><a href="http://git-scm.com/documentation">Git documentation</a></li>
                  </ul>

                <h2>Request information</h2>
                <p>Page view count:
               <?php
                    use Cake\Datasource\ConnectionManager;

                    $hasDB=1;
                    $tableExisted=0;
                    try {
                      $connection = ConnectionManager::get('default');
                    } catch(Exception $e) {
                      $hasDB=0;
                    }
                    if ($hasDB) {
                        try {
                          $connection->execute('create table view_counter (c integer)');
                        } catch (Exception $e) {
                        	$tableExisted=1;
                        }
                        try {
                            if ($tableExisted==0) {
                            	$connection->execute('insert into view_counter values(1)');
                            } else {
                                $connection->execute('update view_counter set c=c+1');
                            }
                            $result=$connection->execute('select * from view_counter')->fetch('assoc');;
                        } catch (Exception $e) {
                            $hasDB=0;
                        }
                    }
                ?>
                <?php if ($hasDB==1) : ?>
                   <span class="code" id="count-value"><?php print_r($result['c']); ?></span>
                   </p>
                <?php else : ?>
                   <span class="code" id="count-value">No database configured</span>
                   </p>
                <?php endif; ?>

          </section>
        </div>