<?php

namespace ShieldSSO\Migrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\DBAL\Migrations\AbstractMigration;

class Version20170806102219CreateDatabase extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        $this->addSql('CREATE SEQUENCE sso_oauth_access_token_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE sso_oauth_authorization_code_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE sso_oauth_client_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE sso_oauth_refresh_token_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE sso_oauth_scope_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE sso_oauth_user_id_seq INCREMENT BY 1 MINVALUE 1 START 1');

        $this->addSql('CREATE TABLE sso_oauth_access_token (id INT NOT NULL, refresh_token_id INT DEFAULT NULL, user_id INT DEFAULT NULL, client_id INT DEFAULT NULL, code VARCHAR(255) NOT NULL, expiryDateTime TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, revoked BOOLEAN NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_F70B97FA77153098 ON sso_oauth_access_token (code)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_F70B97FAF765F60E ON sso_oauth_access_token (refresh_token_id)');
        $this->addSql('CREATE INDEX IDX_F70B97FAA76ED395 ON sso_oauth_access_token (user_id)');
        $this->addSql('CREATE INDEX IDX_F70B97FA19EB6921 ON sso_oauth_access_token (client_id)');

        $this->addSql('CREATE TABLE sso_oauth_access_token_scope (access_token_id INT NOT NULL, scope_id INT NOT NULL, PRIMARY KEY(access_token_id, scope_id))');
        $this->addSql('CREATE INDEX IDX_3A329A642CCB2688 ON sso_oauth_access_token_scope (access_token_id)');
        $this->addSql('CREATE INDEX IDX_3A329A64682B5931 ON sso_oauth_access_token_scope (scope_id)');

        $this->addSql('CREATE TABLE sso_oauth_authorization_code (id INT NOT NULL, user_id INT DEFAULT NULL, client_id INT DEFAULT NULL, code VARCHAR(255) NOT NULL, expiryDateTime TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, revoked BOOLEAN NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_2CE5AE6077153098 ON sso_oauth_authorization_code (code)');
        $this->addSql('CREATE INDEX IDX_2CE5AE60A76ED395 ON sso_oauth_authorization_code (user_id)');
        $this->addSql('CREATE INDEX IDX_2CE5AE6019EB6921 ON sso_oauth_authorization_code (client_id)');

        $this->addSql('CREATE TABLE sso_oauth_authorization_code_scope (authorization_code_id INT NOT NULL, scope_id INT NOT NULL, PRIMARY KEY(authorization_code_id, scope_id))');
        $this->addSql('CREATE INDEX IDX_9D82996C847B7245 ON sso_oauth_authorization_code_scope (authorization_code_id)');
        $this->addSql('CREATE INDEX IDX_9D82996C682B5931 ON sso_oauth_authorization_code_scope (scope_id)');

        $this->addSql('CREATE TABLE sso_oauth_client (id INT NOT NULL, name VARCHAR(255) NOT NULL, secret VARCHAR(255) NOT NULL, redirectUri VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_2F21C4D25E237E06 ON sso_oauth_client (name)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_2F21C4D26E3DB5BC ON sso_oauth_client (redirectUri)');

        $this->addSql('CREATE TABLE sso_oauth_refresh_token (id INT NOT NULL, code VARCHAR(255) NOT NULL, expiryDateTime TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, revoked BOOLEAN NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_D90F7AB777153098 ON sso_oauth_refresh_token (code)');

        $this->addSql('CREATE TABLE sso_oauth_scope (id INT NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_DDBBE1945E237E06 ON sso_oauth_scope (name)');

        $this->addSql('CREATE TABLE sso_oauth_user (id INT NOT NULL, login VARCHAR(255) NOT NULL, password VARCHAR(255) NOT NULL, active VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_945B5826AA08CB10 ON sso_oauth_user (login)');

        $this->addSql('ALTER TABLE sso_oauth_access_token ADD CONSTRAINT FK_F70B97FAF765F60E FOREIGN KEY(refresh_token_id) REFERENCES sso_oauth_refresh_token(id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE sso_oauth_access_token ADD CONSTRAINT FK_F70B97FAA76ED395 FOREIGN KEY(user_id) REFERENCES sso_oauth_user(id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE sso_oauth_access_token ADD CONSTRAINT FK_F70B97FA19EB6921 FOREIGN KEY(client_id) REFERENCES sso_oauth_client(id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE sso_oauth_access_token_scope ADD CONSTRAINT FK_3A329A642CCB2688 FOREIGN KEY(access_token_id) REFERENCES sso_oauth_access_token(id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE sso_oauth_access_token_scope ADD CONSTRAINT FK_3A329A64682B5931 FOREIGN KEY(scope_id) REFERENCES sso_oauth_scope(id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE sso_oauth_authorization_code ADD CONSTRAINT FK_2CE5AE60A76ED395 FOREIGN KEY(user_id) REFERENCES sso_oauth_user(id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE sso_oauth_authorization_code ADD CONSTRAINT FK_2CE5AE6019EB6921 FOREIGN KEY(client_id) REFERENCES sso_oauth_client(id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE sso_oauth_authorization_code_scope ADD CONSTRAINT FK_9D82996C847B7245 FOREIGN KEY(authorization_code_id) REFERENCES sso_oauth_authorization_code(id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE sso_oauth_authorization_code_scope ADD CONSTRAINT FK_9D82996C682B5931 FOREIGN KEY(scope_id) REFERENCES sso_oauth_scope(id) NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        $this->addSql('DROP SEQUENCE public.sso_oauth_access_token_id_seq');
        $this->addSql('DROP SEQUENCE public.sso_oauth_authorization_code_id_seq');
        $this->addSql('DROP SEQUENCE public.sso_oauth_client_id_seq');
        $this->addSql('DROP SEQUENCE public.sso_oauth_refresh_token_id_seq');
        $this->addSql('DROP SEQUENCE public.sso_oauth_scope_id_seq');
        $this->addSql('DROP SEQUENCE public.sso_oauth_user_id_seq');

        $this->addSql('DROP TABLE public.sso_oauth_authorization_code_scope');
        $this->addSql('DROP TABLE public.sso_oauth_access_token_scope');
        $this->addSql('DROP TABLE public.sso_oauth_access_token');
        $this->addSql('DROP TABLE public.sso_oauth_authorization_code');
        $this->addSql('DROP TABLE public.sso_oauth_refresh_token');
        $this->addSql('DROP TABLE public.sso_oauth_client');
        $this->addSql('DROP TABLE public.sso_oauth_scope');
        $this->addSql('DROP TABLE public.sso_oauth_user');
    }
}
