@extends('layout.landing')

@section('title')
    Icil-icafal - Hello
@stop

@section('alert')
	<div class="alert alert-dismissable alert-success">
	  <button type="button" class="close" data-dismiss="alert">×</button>
	  <p>Bienvenido, has ingresado correctamente.</p>
	</div>
@stop

@section('content')
	<div class="row">
        <div class="col-md-12">
        	<h2>Bienvenido</h2>
			<p>Nullam quis risus eget <a href="#">urna mollis ornare</a> vel eu leo. Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Nullam id dolor id nibh ultricies vehicula.</p>
			<p><small>This line of text is meant to be treated as fine print.</small></p>
			<p>The following snippet of text is <strong>rendered as bold text</strong>.</p>
			<p>The following snippet of text is <em>rendered as italicized text</em>.</p>
			<p>An abbreviation of the word attribute is <abbr title="attribute">attr</abbr>.</p>
			<p>Lorem ipsum Aute consequat in quis commodo eiusmod. Lorem ipsum Quis culpa dolore minim in et mollit Excepteur adipisicing. Lorem ipsum Consequat fugiat non labore dolor aliqua enim et. Lorem ipsum Non sed dolore minim ad do pariatur nostrud exercitation dolore fugiat dolore. Lorem ipsum Sint commodo Excepteur minim in et. Lorem ipsum Ut sint enim commodo velit aute cupidatat labore. Lorem ipsum Culpa dolore anim occaecat cillum culpa amet reprehenderit anim adipisicing.</p>
        </div>
    </div>
@stop