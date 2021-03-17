<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210225035233 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE agence ADD compte_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE agence ADD CONSTRAINT FK_64C19AA9F2C56620 FOREIGN KEY (compte_id) REFERENCES compte (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_64C19AA9F2C56620 ON agence (compte_id)');
        $this->addSql('ALTER TABLE compte ADD caissier_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE compte ADD CONSTRAINT FK_CFF65260B514973B FOREIGN KEY (caissier_id) REFERENCES user (id)');
        $this->addSql('CREATE INDEX IDX_CFF65260B514973B ON compte (caissier_id)');
        $this->addSql('ALTER TABLE transaction ADD compte_id INT DEFAULT NULL, ADD retrait_client_id INT DEFAULT NULL, ADD depot_client_id INT DEFAULT NULL, ADD retrait_user_agence_id INT DEFAULT NULL, ADD depot_user_agence_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE transaction ADD CONSTRAINT FK_723705D1F2C56620 FOREIGN KEY (compte_id) REFERENCES compte (id)');
        $this->addSql('ALTER TABLE transaction ADD CONSTRAINT FK_723705D122C6E3C6 FOREIGN KEY (retrait_client_id) REFERENCES client (id)');
        $this->addSql('ALTER TABLE transaction ADD CONSTRAINT FK_723705D1EDBCCE5 FOREIGN KEY (depot_client_id) REFERENCES client (id)');
        $this->addSql('ALTER TABLE transaction ADD CONSTRAINT FK_723705D1C3F2C9F2 FOREIGN KEY (retrait_user_agence_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE transaction ADD CONSTRAINT FK_723705D1900D78C3 FOREIGN KEY (depot_user_agence_id) REFERENCES user (id)');
        $this->addSql('CREATE INDEX IDX_723705D1F2C56620 ON transaction (compte_id)');
        $this->addSql('CREATE INDEX IDX_723705D122C6E3C6 ON transaction (retrait_client_id)');
        $this->addSql('CREATE INDEX IDX_723705D1EDBCCE5 ON transaction (depot_client_id)');
        $this->addSql('CREATE INDEX IDX_723705D1C3F2C9F2 ON transaction (retrait_user_agence_id)');
        $this->addSql('CREATE INDEX IDX_723705D1900D78C3 ON transaction (depot_user_agence_id)');
        $this->addSql('ALTER TABLE user ADD agence_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE user ADD CONSTRAINT FK_8D93D649D725330D FOREIGN KEY (agence_id) REFERENCES agence (id)');
        $this->addSql('CREATE INDEX IDX_8D93D649D725330D ON user (agence_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE agence DROP FOREIGN KEY FK_64C19AA9F2C56620');
        $this->addSql('DROP INDEX UNIQ_64C19AA9F2C56620 ON agence');
        $this->addSql('ALTER TABLE agence DROP compte_id');
        $this->addSql('ALTER TABLE compte DROP FOREIGN KEY FK_CFF65260B514973B');
        $this->addSql('DROP INDEX IDX_CFF65260B514973B ON compte');
        $this->addSql('ALTER TABLE compte DROP caissier_id');
        $this->addSql('ALTER TABLE transaction DROP FOREIGN KEY FK_723705D1F2C56620');
        $this->addSql('ALTER TABLE transaction DROP FOREIGN KEY FK_723705D122C6E3C6');
        $this->addSql('ALTER TABLE transaction DROP FOREIGN KEY FK_723705D1EDBCCE5');
        $this->addSql('ALTER TABLE transaction DROP FOREIGN KEY FK_723705D1C3F2C9F2');
        $this->addSql('ALTER TABLE transaction DROP FOREIGN KEY FK_723705D1900D78C3');
        $this->addSql('DROP INDEX IDX_723705D1F2C56620 ON transaction');
        $this->addSql('DROP INDEX IDX_723705D122C6E3C6 ON transaction');
        $this->addSql('DROP INDEX IDX_723705D1EDBCCE5 ON transaction');
        $this->addSql('DROP INDEX IDX_723705D1C3F2C9F2 ON transaction');
        $this->addSql('DROP INDEX IDX_723705D1900D78C3 ON transaction');
        $this->addSql('ALTER TABLE transaction DROP compte_id, DROP retrait_client_id, DROP depot_client_id, DROP retrait_user_agence_id, DROP depot_user_agence_id');
        $this->addSql('ALTER TABLE user DROP FOREIGN KEY FK_8D93D649D725330D');
        $this->addSql('DROP INDEX IDX_8D93D649D725330D ON user');
        $this->addSql('ALTER TABLE user DROP agence_id');
    }
}
