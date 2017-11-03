<div class="users view">
    <table class="vertical-table">
        <tr>
            <th scope="row"><?= __('Nome') ?></th>
            <td><?= h($user->nome) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('E-mail') ?></th>
            <td><?= h($user->email) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Senha') ?></th>
            <td><?= $this->Html->link("Alterar senha",['controller'=>'Users','action'=>'requestNewPassword'])?></td>
        </tr>
        
    </table>
</div>

<!--div class="surveys index"  id="SurveysModel">
    <h4> Respostas dadas para o feedback de uso </h4>
    <table cellpadding="0" cellspacing="0">
    <thead>
            <tr>
                <th>Data</th>
                <th>Ações</th>
            </tr>
        </thead>
        <tbody>
        <!-- ko foreach: respostasFeedback -->
            <!--tr class='respostas'>
                <td>
                   <p data-bind='text: modified().toLocaleString()'></p>     
                </td>    
                <td>
                    <!-- <input type='hidden' data-bind='value:id'/>
                    <a data-bind='click: $root.delete.bind(this,$data)'>Deletar</a>
                    <a data-bind="attr:{href:viewUrl}">View</a> -->
                <!--/td>
            </tr>
        <!-- /ko -->
        <!--/tbody>
    </table>
</div-->

<script>
    // requirejs(['/js/init.js'],function(){
    //    requirejs(['/js/app/Controllers/UserView.js']);
    // });
</script>
