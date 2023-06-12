<div id="sidebar">
    <ul>
        <li>
        <?= $this->Html->link('Teachers List', ['controller' => 'Teachers', 'action' => 'index']) ?>

        </li>
        <li>
        <?= $this->Html->link('Students List', ['controller' => 'Students', 'action' => 'index']) ?>
       
        </li>
        <li>
           <?= $this->Html->link('Classes List', ['controller' => 'SchoolClasses', 'action' => 'index']) ?>
        </li>
        <li>
        <a href="/swagger-ui/index.html">Swagger UI Api</a>
        </li>
        <li>
           <?= $this->Html->link('Fill the database', ['controller' => 'Facker', 'action' => 'generateAllData']) ?>
        </li>
    </ul>
</div>