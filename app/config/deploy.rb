set   :stages,                  %w(staging production)
set   :default_stage,           "staging"
set   :stage_dir,               "app/config/deploy"
require 'capistrano/ext/multistage'

set   :application,             "letskickin"
set   :deploy_via,              :remote_cache

set   :scm,                     :git
set   :repository,              "git@bitbucket.org:letskickin/webv2.git"

set   :use_sudo,                false
set   :keep_releases,           3

set   :writable_dirs,           ["app/cache", "app/logs"]
set   :webserver_user,          "www-data"
set   :permission_method,       :acl

set   :shared_files,            ["app/config/parameters.yml"]
set   :shared_children,         [app_path + "/logs", app_path + "/sessions", web_path + "/uploads", "vendor"]
set   :use_composer,            true

set   :dump_assetic_assets,     true

#logger.level =                  Logger::IMPORTANT
logger.level =                  Logger::MAX_LEVEL