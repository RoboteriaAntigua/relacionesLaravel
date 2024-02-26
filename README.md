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

    #Resumen metodos 1 a 1
        Entidad fuerte => $this->hasOne( 'modelo debil' )
        Entidad debil => $this->belongsTo( 'modelo fuerte' )

    # Falta agregar factorys y seeders o campos manualmente y probar con tinker

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

    # Metodos a los modelos
        User hasMany posts
        Post belongsTo User
        Post belongsTo categorias
        Categoria hasMany posts

        # modelo User
            public function posts(){
                return $this->hasMany('App\Models\Post');
            }

        # modelo Post
            public function user(){
                return $this->belongsTo('App\Models\User');
            }
            public function categoria(){
                return $this->belongsTo('App\Models\Categoria');
            }

        # Modelo Categoria
            public function posts(){
                return $this->hasMany('App\Models\Post');
            }