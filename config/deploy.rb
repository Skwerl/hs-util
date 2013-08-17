# APPLICATION
set :application, 'hs-util'
set :user, 'deploy'

# We're not a Rails app
set :normalize_asset_timestamps, false

# GITHUB
set :scm, :git
set :repository, 'git@github.com:reyinteractive/hs-util.git'
set :branch, 'production'
set :use_sudo, false
default_run_options[:pty] = true
set :deploy_via, :remote_cache

# ENVIRONMENTS
set :deploy_to, "/srv/#{application}"

task :production do
  set :top_level_task, "production"
  role :web, 'api-sch01.hsym'
end

# AFTER DEPLOY TRIGGERS
after 'deploy', 'git:tag'

namespace :git do
  desc "Tag the head of :branch as a release and push to origin."
  task :tag, :roles => :app do
    timestamp = `date +%Y-%m-%d-%H%M%S`.chomp
    tag       = "release/#{top_level_task}/#{timestamp}"
    deployed_branch = respond_to?(:branch) ? branch : 'HEAD'

    `git tag #{tag} #{deployed_branch} && git push origin refs/tags/#{tag}`
  end
end
