<?php

namespace App\Models;

use App\Entities\Produto;


class ProdutoModel extends MyBaseModel
{
    protected $table            = 'produtos';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = Produto::class;
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = [
        'category_id',
        'nome',
        'price',
        'description',
    ];

    protected bool $allowEmptyInserts = true;
    protected bool $updateOnlyChanged = true;


    // Dates
    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';


    public function listarProdutos(int|null $perPage = null, int|null $page = null)
    {
        $this->setSQLMode();

        $builder = $this;


        $tableFields = [
            'produtos.*',
            'categorias.nome AS categoria'
        ];

        $builder->select($tableFields);

        $builder->join('categorias', 'categorias.id = produtos.category_id');
        $builder->groupBy('produtos.id'); // para não repetir registros
        $builder->orderBy('produtos.id', 'DESC');

        $produtos = $this->paginate(perPage: $perPage, page: $page);

        if (!empty($produtos)) {

            foreach ($produtos as $produto) {

                $produto->images = $this->getProdutoImages($produto->id);
            }
        }

        return $produtos;
    }

    public function getProdutoImages(int $produtoID): array
    {
        return $this->db->table('produtos_images')->where('produto_id', $produtoID)->get()->getResult();
    }

    public function trySaveAdvert(Produto $produto, bool $protect = true)
    {
        try {

            $this->db->transStart();

            $this->protect($protect)->save($produto);

            $this->db->transComplete();
        } catch (\Exception $e) {

            log_message('error', '[ERROR] {exception}', ['exception' => $e]);

            die('Erro ao salvar os dados!');
        }
    }

    public function tryStoreProdutoImages(array $dataImages)
    {
        try {

            $this->db->transStart();

            $this->db->table('produtos_images')->insertBatch($dataImages);

            $this->db->transComplete();
        } catch (\Exception $e) {

            log_message('error', '[ERROR] {exception}', ['exception' => $e]);

            die('Erro ao salvar os dados!');
        }
    }

    public function tryDeleteProdutoImage(int $produtoID, string $image)
    {
        $criteria = [
            'produto_id' => $produtoID,
            'image'     => $image
        ];

        return $this->db->table('produtos_images')->where($criteria)->delete();
    }

    public function tryDeleteProduto(int $produtoID)
    {
        try {

            $this->db->transStart();

            $this->delete($produtoID, true);

            $this->db->transComplete();
        } catch (\Exception $e) {

            log_message('error', '[ERROR] {exception}', ['exception' => $e]);

            die('Erro ao excluir dados!');
        }
    }
}
