<?php

namespace MarekApp;

class Votes {
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
 
    public function getOne($color) {
        $stmt = $this->pdo->query('SELECT "color", SUM("votes") v FROM "votes" '
                . 'WHERE LOWER("color") = \''.strtolower($color).'\''
                . 'GROUP BY "color"' 
        );
        $tab = [];
        while ($row = $stmt->fetch(\PDO::FETCH_ASSOC)) {
            $tab[] = $row['v'];
        }
        return $tab;
    }

    public function all() {
        $stmt = $this->pdo->query('SELECT * '
              . 'FROM "votes" ' 
        );
        $tab = [];
        while ($row = $stmt->fetch(\PDO::FETCH_ASSOC)) {
            $tab[] = [ 'votes' => $row['votes'] ];
        }
        return $tab;
    }

    /**
     * create tables 
     */
    public function createTableWithData() {
        $sqlList = ['CREATE TABLE IF NOT EXISTS votes (
                        city character varying (30) NOT NULL,
                        color character varying (30) NOT NULL,
                        votes INTEGER  NOT NULL  DEFAULT 0  
                    )'];
 
        // execute each sql statement to create new tables
        foreach ($sqlList as $sql) {
            $this->pdo->exec($sql);
            $all = $this->all();
            if(empty($all)){
                // pass values to the statement
                $insert = [
                    ['Anchorage', 'Blue', '10000'],
                    ['Anchorage', 'Yellow', '15000'],
                    ['Brooklyn', 'Red', '100000'],
                    ['Brooklyn', 'Blue', '250000'],
                    ['Detroit', 'Red', '160000'],
                    ['Selma', 'Yellow', '160000'],
                    ['Selma', 'Violet', '5000'],
                ];
                foreach($insert as $key => $data){
                    $this->insertFreshData($data);
                }
            }
        }
        return $this;
    }

    /**
     * fresh votes on the way
     */
    public function insertFreshData($data) {
        // prepare statement for insert
        $sql = 'INSERT INTO votes(city, color, votes) VALUES(:city, :color, :votes)';
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindValue(':city', $data[0]);
        $stmt->bindValue(':color', $data[1]);
        $stmt->bindValue(':votes', $data[2]);
        $stmt->execute();
    }

}