# To get started with security, check out the documentation:
# http://symfony.com/doc/current/security.html
security:

    # http://symfony.com/doc/current/security.html#b-configuring-how-users-are-loaded
    providers:
        in_memory:
            memory:
                users:
                    mary:
                        password: $2y$12$.yAxPVoSRE0wvGQxYpCMq.e.2daOL5Bo52us8kLvvDAQP5.gYzB8a
                        roles: 'ROLE_USER'
                    admin:
                        password: $2y$12$.yAxPVoSRE0wvGQxYpCMq.e.2daOL5Bo52us8kLvvDAQP5.gYzB8a
                        roles: 'ROLE_ADMIN'

        fos_userbundle:
            id: fos_user.user_provider.username

    encoders:
        Symfony\Component\Security\Core\User\User:
            algorithm: bcrypt
            cost: 12

        FOS\UserBundle\Model\UserInterface: bcrypt

    role_hierarchy:
        ROLE_ADMIN:       ROLE_USER
        ROLE_SUPER_ADMIN: ROLE_ADMIN

    firewalls:
        # disables authentication for assets and the profiler, adapt it according to your needs
        dev:
            pattern: ^/(_(profiler|wdt)|css|images|js)/
            security: false

        main:
            pattern: ^/
            form_login:
                provider: fos_userbundle
                csrf_token_generator: security.csrf.token_manager
            logout:       true
            anonymous:    true

        default:
            anonymous: ~
            http_basic: ~

        new_and_edit:
            pattern: /(new)|(edit)
            methods: [GET, POST]
            anonymous: ~
            http_basic: ~

        delete:
            pattern: /
            methods: [DELETE]
            anonymous: ~
            http_basic: ~

    access_control:

         - { path: ^/login$, role: IS_AUTHENTICATED_ANONYMOUSLY }
         - { path: ^/register, role: IS_AUTHENTICATED_ANONYMOUSLY }

         - { path: sales, roles: IS_AUTHENTICATED_FULLY }
         - { path: account, roles: IS_AUTHENTICATED_FULLY }
         - { path: customer/account, roles: IS_AUTHENTICATED_FULLY }

         - { path: manager, roles: ROLE_ADMIN }
         - { path: order, roles: ROLE_ADMIN }
         - { path: product/list, roles: ROLE_ADMIN }
         - { path: category/list, roles: ROLE_ADMIN }
         - { path: new, roles: ROLE_ADMIN }
         - { path: edit, roles: ROLE_ADMIN }
         - { path: /, roles: ROLE_ADMIN, methods: [DELETE] }