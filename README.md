<h2>Overall Project</h2>
<strong>This project concist of 3 database usage.</strong>
<ol>
<li>Two MySQL Database</li>
<li>One SQL Server Database</li>
</ol> 

    
<strong>Main database is MySQL.</strong>
    
<strong>Another two database used to pool/provide data from API request.In this case</strong>
<ol>
<li>SPIKPA data use SQL Server</li>
<li>VCS data use MySQL</li>
</ol> 
 
    
Example Enviroment Setup

![image](https://user-images.githubusercontent.com/27876641/134313281-9c18d43a-feeb-450e-b762-3d00bf87cd69.png)

    
Create those database or get real database

<h2>STEP TO LIVE UP APPLICATION</h2>
<ol>
    <li>Composer Install</li>
    <li>php artisan key:generate</li>
    <li>Php artisan migrate:fresh --seed
        <ol>
            <li>admin@admin.com / Admin#123</li>
            <li>spikpa@user.com / Admin#123</li>
            <li>vcs@user.com / Admin#123</li>
            <li>bms@user.com / Admin#123</li>
        </ol> 
    </li>
    <li>Open Models/Role.php and add "protected $guard_name = 'api';" (Refer Image Below)</li>
</ol> 



    
![image](https://user-images.githubusercontent.com/27876641/134312913-b0468f9f-727f-452f-ae37-ef051c1dcf49.png)

