## Capifony config
set   :application,             "letskickin"
set   :domain,                  "#{application}.com"
set   :deploy_to,               "/var/www/"
set   :deploy_via,              :remote_cache

set   :scm,                     :git
set   :repository,              "git@bitbucket.org:letskickin/webv2.git"

role  :web,                     domain
role  :app,                     domain, :primary => true

set   :use_sudo,                false
set   :keep_releases,           3

# Automatically set proper permissions
# NOTE : For multistage usage you just have to override these variables on stage specific files if ever needed.
set   :writable_dirs,           ["app/cache", "app/logs"]
set   :webserver_user,          "www-data"
set   :permission_method,       :acl
set   :use_set_permissions,     true

## Symfony 2 config
set   :shared_files,            ["app/config/parameters.yml"]
set   :shared_children,         [app_path + "/logs", web_path + "/uploads", "vendor"]
set   :use_composer,            true
set   :update_vendors,          true
set   :vendors_mode,            "install"

## Capistrano configuration
set   :model_manager,           "doctrine"
set   :dump_assetic_assets,     true
set   :user,                    "ubuntu"
set   :branch,                  "master"
set   :git_enable_submodules,   1

logger.level                =   Logger::IMPORTANT
#logger.level                =   Logger::MAX_LEVEL

ssh_options[:port]          =   "22"
ssh_options[:forward_agent] =   true
#ssh_options[:keys]          =   [File.join(ENV["HOME"], ".ssh/letskickin.pem")]
default_run_options[:pty]   =   true

namespace :symfony do
  desc "Clear apc cache"
  task :clear_apc do
    capifony_pretty_print "--> Clear apc cache"
    run "#{try_sudo} sh -c 'cd #{latest_release} && #{php_bin} #{symfony_console} apc:clear --env=#{symfony_env_prod}'"
    capifony_puts_ok
  end
end

after "deploy", "symfony:clear_apc"
after "deploy", "deploy:cleanup"