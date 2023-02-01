<?php
/**
 * @var \App\View\AppView $this
 * @var iterable<\App\Model\Entity\Product> $products
 */
?>
  <?= $this->Html->css([
    
    'normalize.min',
    'milligram.min',
    'cake',
    'style'
      
    ]) ?>
     <?php echo $this->Flash->render() ?>
     <?php $session = $this->request->getSession();
echo $session->read('email');
error_reporting(0);

?>

<div class="products index content">
<div class="container-fluid">
<div class="row">
        <div class="products index content col-sm-2">

        <?php echo $this->element('sidebar');?>
  </div>
  <div class="products index content col-sm-10">

    <?= $this->Html->link(__('New Product'), ['action' => 'add'], ['class' => 'button float-right']) ?>
    <h3><?= __('Products') ?></h3>
    <div class="table-responsive">
        <table>
            <thead>
                <tr>
                    <th><?= $this->Paginator->sort('id') ?></th>
                    <th><?= $this->Paginator->sort('product_title') ?></th>
                    <th><?= $this->Paginator->sort('product_description') ?></th>
                    <th><?= $this->Paginator->sort('product_category') ?></th>
                    <th><?= $this->Paginator->sort('product_image') ?></th>
                    <th><?= $this->Paginator->sort('product_tags') ?></th>
                    <th><?= $this->Paginator->sort('status') ?></th>
                    <th><?= $this->Paginator->sort('created_date') ?></th>
                    <th><?= $this->Paginator->sort('modified_date') ?></th>
                    <th class="actions"><?= __('Actions') ?></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($products as $product): ?>
                <tr>
                    <td><?= $this->Number->format($product->id) ?></td>
                    <td><?= h($product->product_title) ?></td>
                    <td><?= h($product->product_description) ?></td>
                    <td><?= $product->product_category === null ? '' : $this->Number->format($product->product_category) ?></td>
                    <td><?= h($product->product_image) ?></td>
                    <td><?= h($product->product_tags) ?></td>
                    <td><?= h($product->status) ?></td>
                    <td><?= h($product->created_date) ?></td>
                    <td><?= h($product->modified_date) ?></td>
                    <td class="actions">
                        <?= $this->Html->link(__('View'), ['action' => 'view', $product->id]) ?>
                        <?= $this->Html->link(__('Edit'), ['action' => 'edit', $product->id]) ?>
                        <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $product->id], ['confirm' => __('Are you sure you want to delete # {0}?', $product->id)]) ?>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
    </div>
    <div class="paginator">
        <ul class="pagination">
            <?= $this->Paginator->first('<< ' . __('first')) ?>
            <?= $this->Paginator->prev('< ' . __('previous')) ?>
            <?= $this->Paginator->numbers() ?>
            <?= $this->Paginator->next(__('next') . ' >') ?>
            <?= $this->Paginator->last(__('last') . ' >>') ?>
        </ul>
       
        <p><?= $this->Paginator->counter(__('Page {{page}} of {{pages}}, showing {{current}} record(s) out of {{count}} total')) ?></p>
    </div>
    </div>
                
</div>
                
