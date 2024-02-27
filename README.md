# Relaciones en laravel


# COnceptos
    ENtidades fuertes: Su existencia no depende de la existencia de otra tabla. Una tabla users suele ser un ejemplo.
    Entidades debiles: No pueden existir sin otras tablas. Un ejemplo seria la tabla perfiles, que depende de la tabla users.

# Relacion 1 a 1
    Entre la tabla profiles y la tabla users.
    php artisan make:migration create_profiles_table
    php artisan make:model Profile

    # $table->id()  => crea un Entero grande sin signo

    # La clave foranea de profiles
        $table->unsignedBigInteger('user_id')->unique()->nullable();
        $table->foreign('user_id')->references('id')
            ->on('users')
            ->onDelete('set null')
            ->onUpdate('cascade');

        Explicacion:
            El campo user_id debe ser del mismo tipo que el campo id de la tabla users.
            El campo user_id es unique() para que se mantenga la relacion 1 a 1, sino seria 1 a muchos.
            El campo user_id es nullable() para poder ser clave foranea con onDelete('set null')

    # Agregar metodo a la entidad fuerte (users)
        $this->hasOne()
        Al modelo User le agregamos un metodo para recuperar el profile de cada user.
         public function profile(){
            return $this->hasOne(Profile::class);       //Tambien podes pasar asi el Profile::class -> 'App\Models\Profile'
            }
        Si el nombre de la llave foranea de profiles no es user_id :
            return $this->hasOne(Profile::class,'nombre_llave_foranea', 'llave_primaria_profiles');
        
    # Agregar metodo a la entidad debil
        $this->belongsTo
        Al modelo Profile le agregamos un metodo para recuperar la info del user
        public function user(){
        // return User::find($this->user_id); o mejor
        return $this->belongsTo('App\Models\User');
    }

# Resumen metodos 1 a 1
        Entidad fuerte => $this->hasOne( 'modelo debil' )
        Entidad debil => $this->belongsTo( 'modelo fuerte' )



# Relacion 1 a muchos
    Relacion fuerte Users con relacion debil Posts con relacion Fuerte Categoriales
    users -> posts <-Categorias
    Un usuario puede tener muchos posts.
    Una categoria abarca a muchos posts.
    Cada post tiene solo 1 usuario y solo 1 categoria.
    # categorias 
        php artisan make:model Categoria -m     (migracion tambien)
    
    #Migraciones posts
        //Relacion con users
         $table->unsignedBigInteger('user_id')->nullable();
         $table->foreign('user_id')->references('id')->on('users')->onDelete('set null')->onUpdate('cascade');
            
            
        //Relacion con categorias
        $table->unsignedBigInteger('categoria_id')->nullable();
        $table->foreign('categoria_id')->references('id')->on('categorias')->onDelete('set null')->onUpdate('cascade');

# Metodos a los modelos (ver modelos)
        User hasMany posts  //1 a 1 
        Post belongsTo User //1 a 1

        Post belongsTo categoria   //muchos a 1
        Categoria hasMany posts     //1 a muchos

        Roles belongsToMany users   //muchos a muchos
        Users belongsToMany Roles   //Muchos a muchos


        //Ejemplo:
            public function user(){
                return $this->belongsTo('App\Models\User');
            }
            public function categoria(){
                return $this->belongsTo('App\Models\Categoria');
            }


# Seeders para probar
    Como hay relaciones, se puede pero es mas complejo crear factorys, entonces voy a crear varios seeders
    para cada tabla:
        php artisan make:seeder ProfileSeeder
        php artisan make:seeder UserSeeder
        php artisan make:seeder CategoriaSeeder
        php artisan make:seeder PostSeeder
    DatabaseSeeder los llamo asi:
        $this->call([
            UserSeeder::class,
            PostSeeder::class,
            ProfileSeeder::class,
            CategoriaSeeder::class,
        ]);
    En lo individual solamente ingreso datos con insert:
     DB::table('categorias')->insert([
            'name' => Str::random(10)
        ]);
    DB::table('users')->insert([
            'name'=>fake()->name(),
            'email'=>fake()->email(),
            'password'=>Str::random(8)
        ]);

# Correr los seeders
    php artisan db:seed 
    Esto tira error porque vamos a intentar asignar claves foraneas de ids que no existen, entonces primero hay que semillar
    las entidades fuertes: users y categorias
        php artisan db:seed --class=UserSeeder  (varias veces)
        php artisan db:seed --class=CategoriaSeeder
    Luego:
        php artisan db:seed     (Puede dar error porque se llenan claves foraneas al azar, repetir varias veces)

# Como recuperar los posts de una categoria:
    use App\Models\Categoria;
    $cate1 =  Categoria::where('id',1)->first();
    $cate1->posts;  //No ->posts()

# Como recuperar los posts que pertenecen a un user:
    use App\Models\User;
    $user = User::where('id',1)->first();
    $user->posts;   //Es un objeto // No ->posts()

# Muchos a Muchos
    Roles a Users. Los usuarios pueden tener muchos roles y los roles muchos usuarios.
        php artisan make:model Role -ms
    Tabla pivote: role_user
        php artisan make:migration create_role_user_table

# Guardar info en la tabla pivote
    $user = User::find(1);
    $user->roles()->attach(2);  //Al usuario de id 1 le cargo el rol de id 2
    $user->roles()->attach(3);  //al user de id:1 le cargo el role de id:3

    $role = Role::find(1);
    $role->users()->attach(4);  //Al role de id:1 le cargo el usuario de id:4
    $role->users()->attach(2);  //Al role de id:1 le cargo el usuario de id:2

    # Ver los roles de un usuario
        $user->roles;
    # Ver los usuarios de un role:
        $role->users;

# Quitar una relacion
    $user = User::find(44);
    $user->roles()->dettach(1);    //Usuario id:44 ya no tiene el rol de id:1

# Muchos a muchos, attach varias relaciones
    $user = User::find(4);                  //Al usuario id: 4 le asignams los roles de id: 2 y 3 y 56
    $user->roles()->attach([2,3,56]);    
# sync
# Muchos a muchos, borrar todas las relaciones de un usuario y agregar nuevas en un solo comando   
    $user = User::find(1);
    $user->roles()->sync([1,2]);        //Borra las relaciones de tabla pivote (roles del usuario 1), y le agrega roles 1 y 2
 
# Resumen
    # 1 a 1
        $this->hasOne()     => Entidad fuerte
        $this->belongsTo()  => Entidad debil

    # 1 a muchos
    $this->hasMany()    => 1 a muchos
    $this->belongsTo()  => muchos a uno

    # Muchos a Muchos
    $this->belongsToMany()
    $this->belongsToMany()