<h2 class="display-4">"School" Project</h2>

<h3>Introduction</h3>
<p>The "School" project is a web application built using the CakePHP framework.</p>

<h3>Features</h3>
<ul>
    <li><strong>Student Management:</strong> Ability to add, edit, delete, and view student information.</li>
    <li><strong>Teacher Management:</strong> Ability to add, edit, delete, and view teacher information.</li>
    <li><strong>Class Management:</strong> Ability to add, edit, delete, and view class information.</li>
    <li><strong>Data Retrieval API:</strong> The application has an API that allows fetching information about teachers and students in JSON format.</li>
    <li><strong>API Documentation with Swagger UI:</strong> The application includes a Swagger UI interface, allowing for a user-friendly way to explore and test API endpoints. Users can browse available API resources, request and response structures, as well as perform requests directly from the Swagger UI interface.</li>
</ul>

<h3>Usage</h3>
<p>After starting the server, open your browser and go to <a href="http://localhost:8765">http://localhost:8765</a> to access the application.</p>
<p>Upon launching the application, you will have an empty database named 'school_db'. You can manually populate it with data or generate test data by clicking on the '<a href="http://localhost:8765/facker/generate-all-data">Fill the database</a>' link.</p>

<h3>Objective of the Application</h3>
<p>The primary objective of this application was to create a system that establishes and manages relationships and tables within a MySQL database. The application's architecture includes defined relationships among the tables, leveraging CakePHP's ORM capabilities. These relationships allow for efficient data retrieval and manipulation within the database.</p>

<h4>Database Relationships</h4>
<p>The application contains several types of relationships among tables:</p>
<ul>
    <li>
        <strong>hasOne:</strong> This relationship is used to associate one record in a model with a single record in another model. For instance, the 'SchoolClasses' model is associated with the 'Teachers' model through the foreign key 'teacher_id'.
        <pre><code>$this-&gt;hasOne('SchoolClasses', [
    'foreignKey' =&gt; 'teacher_id',
]);</code></pre>
    </li>
    <li>
        <strong>belongsTo:</strong> This type of relationship is defined within the model that holds the foreign key. The 'Students' model, for example, belongs to the 'SchoolClasses' model.
        <pre><code>$this-&gt;belongsTo('SchoolClasses', [
    'foreignKey' =&gt; 'school_class_id',
    'joinType' =&gt; 'INNER',
]);</code></pre>
    </li>
    <li>
        <strong>hasMany:</strong> This relationship indicates that a single record in the model is associated with multiple records in another model. For example, a single school class can have many students.
        <pre><code>$this-&gt;hasMany('Students', [
    'foreignKey' =&gt' => 'school_class_id',
]);</code></pre>
    </li>
</ul>
<h4>REST API Endpoints</h4>
<p>In addition to managing database relationships, the application also provides REST API endpoints.
    The endpoints <code>api/students</code> and <code>api/teachers</code> allow for retrieving data regarding teachers, classes, and students based on the specified parameters.
    This functionality is essential for integrating the application with other systems or enabling third-party access to the data.</p>

<h4>Swagger UI for API Documentation</h4>
<p>For enhanced usability and clarity, the application includes Swagger UI integration. Swagger UI offers a visually appealing and interactive interface for exploring the REST API. It provides detailed documentation for the API endpoints and allows users to execute API requests directly from the browser.</p>

<h4>File Structure and Components</h4>
<p>The application is organized into various components to ensure modularity and ease of maintenance. Below is an overview of the main components:</p>

<h5>Controllers</h5>
<p>Controllers are responsible for handling user requests and retrieving or storing data. The application contains several controllers:</p>
<ul>
    <li><code>TeachersController</code>: Manages the actions related to teachers.</li>
    <li><code>StudentsController</code>: Manages the actions related to students.</li>
    <li><code>SchoolClassesController</code>: Manages the actions related to school classes.</li>
    <li><code>FakerController</code>: Used for generating fake data for testing purposes.</li>
    <li><code>Api/ApiTeachersController</code>: Handles API requests related to teachers.</li>
    <li><code>Api/ApiStudentsController</code>: Handles API requests related to students.</li>
</ul>

<h5>Models</h5>
<p>Models define the structure of the database tables and the relationships between them. The main models in the application are:</p>
<ul>
    <li><code>TeachersTable</code>: Defines the structure and relationships for the teachers' data.</li>
    <li><code>StudentsTable</code>: Defines the structure and relationships for the students' data.</li>
    <li><code>SchoolClassesTable</code>: Defines the structure and relationships for the school classes' data.</li>
</ul>
<p>Each table in the model has associated entities, referred to as <code>Entity</code>, which represent individual rows in the table.</p>
<br>
<h5>View Files</h5>
<p>View files contain the HTML and PHP code that is rendered in the browser. There are dedicated view files for each controller to display the corresponding data.</p>

<h5>Config Directory</h5>
<p>The config directory contains configuration files that define settings and constants used throughout the application. Key files in this directory include:</p>
<ul>
    <li><code>school_classes.php</code>: Contains configuration settings for school classes.</li>
    <li><code>language_groups.php</code>: Contains configuration settings for language groups.</li>
    <li><code>gender_groups.php</code>: Contains configuration settings for gender groups.</li>
</ul>
<br /><br /><br />