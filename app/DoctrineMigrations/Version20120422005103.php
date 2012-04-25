<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration,
    Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your need!
 */
class Version20120422005103 extends AbstractMigration
{
    public function up(Schema $schema)
    {
        // this up() migration is autogenerated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != "mysql");
        
        $this->addSql("DROP TABLE GrooveSlotTag");
        $this->addSql("ALTER TABLE groove_slot ADD winning_groove INT DEFAULT NULL");
        $this->addSql("ALTER TABLE project DROP winning_groove_set_id");
    }

    public function down(Schema $schema)
    {
        // this down() migration is autogenerated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != "mysql");
        
        $this->addSql("CREATE TABLE GrooveSlotTag (id INT AUTO_INCREMENT NOT NULL, groove_slot_id INT NOT NULL, tag_id INT NOT NULL, PRIMARY KEY(id)) ENGINE = InnoDB");
        $this->addSql("ALTER TABLE groove_slot DROP winning_groove");
        $this->addSql("ALTER TABLE project ADD winning_groove_set_id INT DEFAULT NULL");
    }
}