<?php

namespace MarekApp;

class Colors {
    /**
     * PDO object
     * @var \PDO
     */
    private $pdo;
 
    /**
     * init the object with a \PDO object
     * @param type $pdo
     */
    public function __construct($pdo) {
        $this->pdo = $pdo;
        //I am not sure if you have everything set up correctly in DB
        $this->createTableWithData();
    }
 
    public function all() {
        $stmt = $this->pdo->query('SELECT "color" '
              . 'FROM "colors" ' 
        );
        $tab = [];
        while ($row = $stmt->fetch(\PDO::FETCH_ASSOC)) {
            $tab[] = [ 'color' => $row['color'] ];
        }
        return $tab;
    }

    /**
     * create tables 
     */
    public function createTableWithData() {
        $sqlList = ['CREATE TABLE IF NOT EXISTS colors (
                        color character varying (30) NOT NULL UNIQUE 
                    )'];
 
        // execute each sql statement to create new tables
        foreach ($sqlList as $sql) {
            $this->pdo->exec($sql);
            $all = $this->all();
            if(empty($all)){
                // pass values to the statement
                $colors = ['Red', 'Orange', 'Yellow', 'Green', 'Blue', 'Indigo', 'Violet'];
                foreach($colors as $key => $color){
                    $this->insertFreshData($color);
                }
            }
        }
        return $this;
    }

    /**
     * fresh colors on the way
     */
    public function insertFreshData($color) {
        // prepare statement for insert
        $sql = 'INSERT INTO colors(color) VALUES(:color)';
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindValue(':color', $color);
        $stmt->execute();
    }

}