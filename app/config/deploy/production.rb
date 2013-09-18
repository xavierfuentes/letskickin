set     :domain,            "letskickin.com"

server  "#{domain}",        :app, :web, :db, :primary => true
set     :user,              "vagrant"
set     :deploy_to,         "/var/www/#{domain}"
#set     :branch,            "prod"

set     :symfony_env_prod,  "prod"

logger.level = Logger::MAX_LEVEL

after "deploy",             "deploy:cleanup"

ssh_options[:keys]          =   ['~/.vagrant.d/insecure_private_key']
ssh_options[:forward_agent] =   true
