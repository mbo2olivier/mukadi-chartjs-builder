<?php
namespace Mukadi\Chart\Fetcher;

use Mukadi\Chart\DataFetcherInterface;

class DataFetcher implements DataFetcherInterface {

    public function __construct(private \PDO $connection)
    {
        
    }

    public function execute(string $sql, array $vars = []): iterable
    {

        if (count($vars) > 0) {
            $s = $this->connection->prepare($sql);
            foreach($vars as $p => $val) {
                $type = \PDO::PARAM_STR;

                if (is_integer($val))
                    $type = \PDO::PARAM_INT;
                else if (is_bool($val))
                    $type = \PDO::PARAM_BOOL;
                else if (is_null($val))
                    $type = \PDO::PARAM_NULL;

                $s->bindParam($p, $val, $type);
            }
            $s->execute();
            return $s->fetchAll();
        }else{
            return $this->connection->query($sql);
        }
    }
}