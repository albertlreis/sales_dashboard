<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230824052603 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE sale ADD client_id INT NOT NULL, DROP client');
        $this->addSql('ALTER TABLE sale ADD CONSTRAINT FK_E54BC00519EB6921 FOREIGN KEY (client_id) REFERENCES client (id)');
        $this->addSql('CREATE INDEX IDX_E54BC00519EB6921 ON sale (client_id)');
        $this->addSql('ALTER TABLE sale_item ADD sale_id INT NOT NULL, ADD product_id INT NOT NULL, DROP product, DROP sale');
        $this->addSql('ALTER TABLE sale_item ADD CONSTRAINT FK_A35551FB4A7E4868 FOREIGN KEY (sale_id) REFERENCES sale (id)');
        $this->addSql('ALTER TABLE sale_item ADD CONSTRAINT FK_A35551FB4584665A FOREIGN KEY (product_id) REFERENCES product (id)');
        $this->addSql('CREATE INDEX IDX_A35551FB4A7E4868 ON sale_item (sale_id)');
        $this->addSql('CREATE INDEX IDX_A35551FB4584665A ON sale_item (product_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE sale DROP FOREIGN KEY FK_E54BC00519EB6921');
        $this->addSql('DROP INDEX IDX_E54BC00519EB6921 ON sale');
        $this->addSql('ALTER TABLE sale ADD client VARCHAR(255) NOT NULL, DROP client_id');
        $this->addSql('ALTER TABLE sale_item DROP FOREIGN KEY FK_A35551FB4A7E4868');
        $this->addSql('ALTER TABLE sale_item DROP FOREIGN KEY FK_A35551FB4584665A');
        $this->addSql('DROP INDEX IDX_A35551FB4A7E4868 ON sale_item');
        $this->addSql('DROP INDEX IDX_A35551FB4584665A ON sale_item');
        $this->addSql('ALTER TABLE sale_item ADD product VARCHAR(255) NOT NULL, ADD sale VARCHAR(255) NOT NULL, DROP sale_id, DROP product_id');
    }
}
