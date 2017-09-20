<h1><?=$survey->nome?></h1>

<?php //TODO survey helper ?>
<?php 
// foreach($survey->perguntas as $pergunta): 
//     $this->Pergunta->getPergunta($pergunta);
// endforeach; 
$this->Survey->printForm($survey);
?>