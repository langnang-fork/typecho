<?php

namespace Widget\Metas;

use Typecho\Db\Exception;
use Widget\Base\Metas;
use Widget\Base\TreeTrait;
use Widget\Metas\Category\InitTreeRowsTrait;

class From extends Metas
{
    use InitTreeRowsTrait;
    use TreeTrait {
        initParameter as initTreeParameter;
    }

    /**
     * @return void
     * @throws Exception
     */
    public function execute()
    {
        $query = null;

        if (isset($this->parameter->mid)) {
            $query = $this->select()->where('mid = ?', $this->parameter->mid);
        } elseif (isset($this->parameter->query)) {
            $query = $this->parameter->query;
        }

        if ($query) {
            $this->db->fetchAll($query, [$this, 'push']);

            if ($this->type == 'category') {
                $this->initTreeParameter($this->parameter);
            }
        }
    }
}
