<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class HashUserPasswords extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'user:hash-passwords';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Hashes the passwords of existing users if they are not already hashed';

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
     * @return int
     */
    public function handle()
    {
        $users = User::all();

        foreach ($users as $user) {
            // Check if the password is not already hashed with Bcrypt
            if (strlen($user->password) < 60 || !Hash::needsRehash($user->password)) {
                $user->password = Hash::make($user->password);
                $user->save();
                $this->info('Password hashed for user: ' . $user->email);
            }
        }

        $this->info('All user passwords have been hashed.');

        return 0;
    }
}