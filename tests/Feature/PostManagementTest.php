<?php

namespace Tests\Feature;

use App\Post;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class PostManagementTest extends TestCase
{

    use RefreshDatabase;

    /** @test */
    public function list_posts_can_be_retrieved(){

        // Hacer el error mas entendible
        $this->withoutExceptionHandling();

        // Generar datos de pruebas
        factory(Post::class, 3)->create();

        // Traerme todos los datos
        $response = $this->get('/posts');

        // Validar respuesta OK del test
        $response->assertOk();

        // Traer todos los posts
        $posts = Post::all();

        // Esto valida que si retorne la vista
        $response->assertViewIs('posts.index');

        // Validar que en la vista 'posts.index'
        // si llegue la vartiable $posts
        $response->assertViewHas('posts', $posts);

    }

    /** @test */
    public function a_post_can_be_retrieved(){

        // Hacer el error mas entendible
        $this->withoutExceptionHandling();

        // Generar datos de pruebas
        $post = factory(Post::class)->create();

        // Traerme todos los datos
        $response = $this->get('/posts/' . $post->id);

        // Validar respuesta OK del test
        $response->assertOk();

        // Traer todos los posts
        $post = Post::first();

        // Esto valida que si retorne la vista
        $response->assertViewIs('posts.show');

        // Validar que en la vista 'posts.index'
        // si llegue la vartiable $posts
        $response->assertViewHas('post', $post);

    }


    /** @test */
    public function a_post_cant_be_created(){

        // Hacer el error mas entendible
        $this->withoutExceptionHandling();

        // Insertar en ese endpoint, esos datos
        $response = $this->post('/posts', [
            'title'   => 'Test Title',
            'content' => 'Test content',
        ]);
        
        // Validar respuesta OK del test
        // Se hace refractor en el video por que cuando se crea
        // leva a algun lugar
        // $response->assertOk();
        
        // Luego de la respuesta, traer 1 de todos los POSTS
        $this->assertCount(1, Post::all());
        
        // Traer el primer post
        $post = Post::first();

        // Si es igual al que inserte. OK
        $this->assertEquals($post->title,   'Test Title');
        $this->assertEquals($post->content, 'Test content');

        $response->assertRedirect('/posts/' . $post->id);
    }

    /** @test */
    public function post_title_is_required(){

        // Hacer el error mas entendible
        // Se comenta esta linea cuando la prueba arroja el error de: 
        // Illuminate\Validation\ValidationException: The given data was invalid.
        // porque significa que esta cayendo directamente al validador, y hay que hacerlo fallar
        // $this->withoutExceptionHandling();

         // Insertar en ese endpoint, esos datos
         $response = $this->post('/posts', [
            'title'   => '',
            'content' => 'Test content',
        ]);

        $response->assertSessionHasErrors(['title']);
    }

    /** @test */
    public function a_post_cant_be_updated(){

        // Hacer el error mas entendible
        $this->withoutExceptionHandling();

        // Generar datos de pruebas
        $post = factory(Post::class)->create();

        // Insertar en ese endpoint, esos datos
        $response = $this->put('/posts/'.$post->id, [
            'title'   => 'Test Title',
            'content' => 'Test content',
        ]);
        
        // Luego de la respuesta, traer 1 de todos los POSTS
        $this->assertCount(1, Post::all());
        
        // Traer el primer post
        $post = $post->fresh();

        // Si es igual al que inserte. OK
        $this->assertEquals($post->title,   'Test Title');
        $this->assertEquals($post->content, 'Test content');

        $response->assertRedirect('/posts/' . $post->id);
    }

    /** @test */
    public function a_post_cant_be_deleted(){

        // Hacer el error mas entendible
        $this->withoutExceptionHandling();

        // Generar datos de pruebas
        $post = factory(Post::class)->create();

        // Insertar en ese endpoint, esos datos
        $response = $this->delete('/posts/'.$post->id);
        
        // Luego de la respuesta, traer 1 de todos los POSTS
        $this->assertCount(0, Post::all());

        $response->assertRedirect('/posts/');
    }
}
