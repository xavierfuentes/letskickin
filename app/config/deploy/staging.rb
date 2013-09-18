server  "test.letskickin.com",      :app, :web, :db, :primary => true
set     :user,                      "vagrant"
set     :deploy_to,                 "/var/www/letskickin.com"
#set     :branch,                   "test"

# Symfony options
set :symfony_env_prod,              "prod"

# Be more verbose by uncommenting the following line
logger.level = Logger::MAX_LEVEL

set :domain,      "letskickin.com"
role :web,        domain                         # Your HTTP server, Apache/etc
role :app,        domain                         # This may be the same as your `Web` server
role :db,         domain, :primary => true       # This is where Symfony2 migrations will run

after "deploy:copyfiles", "clearapc"

ssh_options[:forward_agent] =   true
default_run_options[:pty]   =   true
ssh_options[:keys]          =   ['~/.vagrant.d/insecure_private_key']

task :clearapc do
  run "php #{release_path}/app/console apc:clear --env=prod"
  puts "      APC cleared for #{branch} version (prod env)."
end
