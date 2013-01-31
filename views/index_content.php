<?=get_messages_from_session()?>
<h1>Index Controller</h1>
<p>Welcome to the Lanaya index controller.</p>

<h3>Download</h3>
<p>You can download Lanaya from github.</p>
<blockquote>
<code>git clone git://github.com/anthuz/lanaya.git</code>
</blockquote>
<p>You can review its source directly on github: <a href='https://github.com/anthuz/lanaya'>https://github.com/anthuz/lanaya</a></p>

<h3>Installation</h3>
<p>First you have to make the data-directory writable. This is the place where Lanaya needs
to be able to write and create files.</p>
<blockquote>
<code>cd Lanaya; chmod 777 site/data</code>
</blockquote>

<p>Second, Lanaya has some modules that need to be initialised. You can do this through a
controller. Point your browser to the following link.</p>
<blockquote>
<a href='<?=create_url('modules/install')?>'>modules/install</a>
</blockquote>