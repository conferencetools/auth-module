<?php


namespace ConferenceTools\Authentication\Auth;


use ConferenceTools\Authentication\Auth\Authenticator\IdentityAuthenticator;
use ConferenceTools\Authentication\Auth\Authenticator\UsernameAndPasswordAuthenticator;
use ConferenceTools\Authentication\Auth\Extractor\PasetoCookie;
use ConferenceTools\Authentication\Auth\Extractor\PostFields;
use ConferenceTools\Authentication\Auth\Resolver\PhactorIdentityResolver;
use ConferenceTools\Authentication\Auth\Resolver\PhactorUsernameAndPasswordResolver;
use ConferenceTools\Authentication\Domain\User\ReadModel\User;
use Interop\Container\ContainerInterface;
use ParagonIE\ConstantTime\Base64;
use ParagonIE\Paseto\Builder;
use ParagonIE\Paseto\Keys\SymmetricKey;
use ParagonIE\Paseto\Parser;
use ParagonIE\Paseto\Protocol\Version1;
use ParagonIE\Paseto\Protocol\Version2;
use ParagonIE\Paseto\Rules\NotExpired;
use Phactor\Zend\RepositoryManager;
use Zend\ServiceManager\Factory\FactoryInterface;

class Factory implements FactoryInterface
{
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        $repositoryManager = $container->get(RepositoryManager::class);
        $repository = $repositoryManager->get(User::class);

        $usernameAndPassword = new UsernameAndPasswordAuthenticator(
            new PostFields('username', 'password'),
            new PhactorUsernameAndPasswordResolver($repository)
        );

        $config = $container->get('Config');

        $version = $config['auth']['version'] ?? 2;

        switch ($version) {
            case 1:
                $protocol = new Version1();
                break;
            case 2:
            default:
                $protocol = new Version2();
        }

        $symmetricKey = new SymmetricKey(Base64::decode($config['auth']['signingKey']), $protocol);

        $parser = Parser::getLocal($symmetricKey);
        $parser->addRule(new NotExpired());

        $builder = Builder::getLocal($symmetricKey, $protocol);

        $persistor = new PasetoCookie($parser, $builder, $config['auth']['loginTimeout'], $config['auth']['cookieOptions']);
        $identity = new IdentityAuthenticator(
            $persistor,
            new PhactorIdentityResolver($repository)
        );

        return new AuthService($persistor, $identity, $usernameAndPassword);
    }
}