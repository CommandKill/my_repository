<?php

use Illuminate\Console\Command;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;

class SiteCommand extends Command {

	/**
	 * The console command name.
	 *
	 * @var string
	 */
	protected $name = 'site:deploy';

	/**
	 * The console command description.
	 *
	 * @var string
	 */
	protected $description = 'Command for deploy this project to production server. please run this command like this "$php artisan site:deploy --env=local"';

	/**
	 * Create a new command instance.
	 *
	 * @return void
	 */
	public function __construct()
	{
		parent::__construct();
	}

	/**
	 * Execute the console command.
	 *
	 * @return mixed
	 */
	public function fire()
	{
		$options = $this->option('env');

		if($options == 'dev'){
			$result = $this->ask('Do you want to deploy only or with run composer update on production server too(Yn)?');
			$commands = array('cd /var/www/easy-listing/');

			if ($result == 'n') {
				$commands[] = 'git pull origin master';
				$commands[] = 'cd /var/www/easy-listing-ssl/';// for https too
				$commands[] = 'git pull origin master';
				$this->info('Deploying...');
			} else {
				$commands[] = 'git pull origin master';
				$commands[] = 'composer update';
				$commands[] = 'cd /var/www/easy-listing-ssl/'; // for https too
				$commands[] = 'git pull origin master';
				$commands[] = 'composer update';
				$this->info('Deploying with run composer update...');
			}

			SSH::into('production')->run($commands, function($line)
			{
			    echo $line.PHP_EOL;
			});
		} else {
			$this->error('please add suffix "--env=dev" like this "$php artisan site:deploy --env=dev", *this command work with local only');
		}

		echo 'Done.'.PHP_EOL;
	}

	/**
	 * Get the console command arguments.
	 *
	 * @return array
	 */
	protected function getArguments()
	{
		return array();
		// return array(
		// 	array('name', InputArgument::REQUIRED, 'An example argument.'),
		// );
		//array($name, $mode, $description, $defaultValue)
	}

	/**
	 * Get the console command options.
	 *
	 * @return array
	 */
	protected function getOptions()
	{
		// return array();
		return array(
			array('env', '', InputOption::VALUE_OPTIONAL, 'An example option.', null),
		);
		//array($name, $shortcut, $mode, $description, $defaultValue)
	}

}
