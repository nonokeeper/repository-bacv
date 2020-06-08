<?php
namespace App\Command;

use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Question\Question;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
class CreateUserCommand extends Command
{
    private $passwordEncoder;
    private $entityManager;
    public function __construct(UserPasswordEncoderInterface $passwordEncoder, EntityManagerInterface $entityManager)
    {
        parent::__construct();
        $this->passwordEncoder = $passwordEncoder;
        $this->entityManager = $entityManager;
    }
    /**
     * {@inheritdoc}
     */
    protected function configure()
    {
        $this
            ->setName('user:create')
            ->setDescription('Create a user.')
            ->setDefinition(array(
                new InputArgument('email', InputArgument::REQUIRED, 'The email'),
                new InputArgument('username', InputArgument::REQUIRED, 'The username'),
                new InputArgument('password', InputArgument::REQUIRED, 'The password'),
                new InputOption('admin', null, InputOption::VALUE_NONE, 'Set the user as admin (ROLE_ADMIN)'),
                new InputOption('super-admin', null, InputOption::VALUE_NONE, 'Set the user as super admin (ROLE_SUPER_ADMIN)'),
            ))
            ->setHelp(<<<'EOT'
The <info>user:create</info> command creates a user:
  <info>php %command.full_name% romaric@netinfluence.ch romaric</info>
This interactive shell will ask you for a password.
You can create a super admin via the "super-admin" flag:
  <info>php %command.full_name% superadmin superadmin@bacv78.fr --super-admin</info>
  You can create an admin via the "admin" flag:
  <info>php %command.full_name% admin admin@bacv78.fr --admin</info>
EOT
            );
    }
    /**
     * {@inheritdoc}
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $email = $input->getArgument('email');
        $username = $input->getArgument('username');
        $password = $input->getArgument('password');
        $superadmin = $input->getOption('super-admin');
        $admin = $input->getOption('admin');
        $user = (new User())
            ->setEmail($email)
            ->setUsername($username)
            ->setRoles(($superadmin ? ['ROLE_SUPER_ADMIN'] : $admin) ? ['ROLE_ADMIN'] : ['ROLE_USER'])
        ;
        $password = $this->passwordEncoder->encodePassword($user, $password);
        $user->setPassword($password);
        $this->entityManager->persist($user);
        $this->entityManager->flush();
        $output->writeln(sprintf('Created user <comment>%s</comment>', $email.'/'.$username));
    }
    /**
     * {@inheritdoc}
     */
    protected function interact(InputInterface $input, OutputInterface $output)
    {
        $questions = array();
        if (!$input->getArgument('password')) {
            $question = new Question('Saisir un mot de passe : ');
            $question->setValidator(function ($password) {
                if (empty($password)) {
                    throw new \Exception('Mot de passe non vide obligatoire !');
                }
                return $password;
            });
            $question->setHidden(true);
            $questions['password'] = $question;
        }
        foreach ($questions as $name => $question) {
            $answer = $this->getHelper('question')->ask($input, $output, $question);
            $input->setArgument($name, $answer);
        }
    }
}