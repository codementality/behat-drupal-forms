# -*- mode: ruby -*-
# vi: set ft=ruby :

# All Vagrant configuration is done below. The "2" in Vagrant.configure
# configures the configuration version (we support older styles for
# backwards compatibility). Please don't change it unless you know what
# you're doing.
Vagrant.configure(2) do |config|
  # The most common configuration options are documented and commented below.
  # For a complete reference, please see the online documentation at
  # https://docs.vagrantup.com.

  # Every Vagrant development environment requires a box. You can search for
  # boxes at https://atlas.hashicorp.com/search.
  #
  # This base box is a Debian Jessie box with a LAMP Stack, Composer, Drush and
  # PhantomJS.  It has MySQL configured and a base database created called
  # "drupal".
  config.vm.box = "savas/acs_debian_jessie"

  # Disable automatic box update checking. If you disable this, then
  # boxes will only be checked for updates when the user runs
  # `vagrant box outdated`. This is not recommended.
  # config.vm.box_check_update = false

  # Create a forwarded port mapping which allows access to a specific port
  # within the machine from a port on the host machine. In the example below,
  # accessing "localhost:8080" will access port 80 on the guest machine.
  # config.vm.network "forwarded_port", guest: 80, host: 8080

  # Create a private network, which allows host-only access to the machine
  # using a specific IP.
  config.vm.network "private_network", ip: "192.168.33.10"

  config.vm.provider "virtualbox" do |vb|
  #   # Don't boot with headless mode
  #   vb.gui = true
  #
  #   # Use VBoxManage to customize the VM. For example to change memory:
     vb.customize ["modifyvm", :id, "--memory", "2048"]
  end

  # Create a public network, which generally matched to bridged network.
  # Bridged networks make the machine appear as another physical device on
  # your network.
  # config.vm.network "public_network"

  # Share an additional folder to the guest VM. The first argument is
  # the path on the host to the actual folder. The second argument is
  # the path on the guest to mount the folder. And the optional third
  # argument is a set of non-required options.
  config.vm.synced_folder ".", "/var/www/sites/drupal"
  config.ssh.insert_key = false
  # Provider-specific configuration so you can fine-tune various
  # backing providers for Vagrant. These expose provider-specific options.
  # Example for VirtualBox:
  #
  # config.vm.provider "virtualbox" do |vb|
  #   # Display the VirtualBox GUI when booting the machine
  #   vb.gui = true
  #
  #   # Customize the amount of memory on the VM:
  #   vb.memory = "1024"
  # end
  #
  # View the documentation for the provider you are using for more
  # information on available options.

  # Define a Vagrant Push strategy for pushing to Atlas. Other push strategies
  # such as FTP and Heroku are also available. See the documentation at
  # https://docs.vagrantup.com/v2/push/atlas.html for more information.
  # config.push.define "atlas" do |push|
  #   push.app = "YOUR_ATLAS_USERNAME/YOUR_APPLICATION_NAME"
  # end

  # Enable provisioning with a shell script. Additional provisioners such as
  # Puppet, Chef, Ansible, Salt, and Docker are also available. Please see the
  # documentation for more information about their specific syntax and use.
  config.vm.provision "shell", inline: <<-SHELL
     nohup phantomjs --webdriver=8643 > /dev/null 2>&1 &
     mysql -u root -proot -e "drop database if exists drupal;"
     mysql -u root -proot -e "create database drupal;"
     if [ -e "/var/www/sites/drupal/db/database.sql" ]
     then
       mysql -u root -proot drupal < /var/www/sites/drupal/db/database.sql
     else
       echo "Please copy your seed database to db/database.sql, then rerun the provisioning command."
     fi
     if [ ! -f "/var/www/sites/drupal/www/sites/default/settings.php" ]
     then
       echo "Please copy your settings.php file to www/sites/default/settings.php, or create a settings.php file to load your site."
     fi
     if [ ! -f "/usr/local/bin/drupal" ]
     then
       curl https://drupalconsole.com/installer -L -o drupal.phar
       sudo mv drupal.phar /usr/local/bin/drupal
       sudo chmod +x /usr/local/bin/drupal
       drupal init --override
     fi
     cd /var/www/sites/drupal
     #cp install/files/settings.php www/sites/default/settings.php
     cd /var/www/sites/drupal/www
     drush updb
     drush entup #drupal8
     # drush fra -y #with features installed
     # drush cc all #drupal 7
     drush cr -y #drupal 8
  SHELL
end

