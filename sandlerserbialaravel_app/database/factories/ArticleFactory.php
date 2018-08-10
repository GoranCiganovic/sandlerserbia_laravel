<?php

/* Article Factory */
$factory->define(App\Article::class, function (Faker\Generator $faker) {
    return [
        'name' => $faker->unique()->word,
        'html' =>  $faker->randomHtml(2, 3),
    ];
});

/* Article Factory - Article 1 */
$factory->defineAs(App\Article::class, '1', function ($faker) use ($factory) {
    $article = $factory->raw(App\Article::class);
    return array_merge($article, [
        'id' => 1,
        'name' => 'Naslov',
        'html' => "<h3 style='text-align:center;' class='text-center'>UGOVOR O PRUŽANJU USLUGA</h3>",
    ]);
});
/* Article Factory - Article 2 */
$factory->defineAs(App\Article::class, '2', function ($faker) use ($factory) {
    $article = $factory->raw(App\Article::class);
    return array_merge($article, [
        'id' => 2,
        'name' => 'Zaglavlje',
        'html' => "<br><br><p>Zaključen dana ... godine u Beogradu između:</p>
				   <ol>
					 <li><b>Davalac usluga: ...</b>, ..., ..., matični broj: ..., PIB: ...,  koga zastupa ...,  ovlašćeni zastupnik</li>
					 i
					 <li><b>Korisnik usluga: ...</b>, ...</li>
				   </ol><br><br>",
        ]);
});
/* Article Factory - Article 3 */
$factory->defineAs(App\Article::class, '3', function ($faker) use ($factory) {
    $article = $factory->raw(App\Article::class);
    return array_merge($article, [
        'id' => 3,
        'name' => 'Članovi 1 i 2',
        'html' => "<p style='text-align:center;' class='text-center'><b>Član 1.</b></p>
			    <p style='text-align:justify;' class='text-justify'>Ovim Ugovorom regulisani su međusobni odnosi i obaveze ugovornih strana, koji proističu iz predmeta ugovaranja – pružanja usluge programa &ldquor;Predsednički Klub&rdquo; za zaposlene u kompaniji Korisnika usluga od strane Davaoca usluga, rokovi i visina naknade usluga, način obavljanja poslova, vreme trajanja i način prestanka Ugovora.</p>
			    <br>
			    <p style='text-align:center;' class='text-center'><b>Član 2.</b></p>
			    <p style='text-align:justify;' class='text-justify'>Davalac usluga se obavezuje da u okviru svoje delatnosti, savesno i odgovorno ispuni sledeće obaveze preuzete iz ovog Ugovora i to:<br>
			    <b>Održavanje projekta Predsednički Klub</b>&nbsp;&nbsp;za zaposlene u kompaniji Korisnika usluga radi njihovog upoznavanja i ovladavanja potrebnim stručnim veštinama, a prema usaglašenom planu i programu Predsedničkog Kluba – &ldquor;Pretvorite znanje u instinkt&rdquo; (u daljem tekstu: &ldquor;Projekat&rdquo;)</p>
			    <p style='text-align:justify;' class='text-justify'>Osnovni cilj projekta jeste da se kod učesnika postigne promena ponašanja, veća inicijativa, <i>&ldquor;pozitivna agresivnost&rdquo;</i> i da vremenom postanu Autoriteti i primeri za ostale kolege u firmi.</p>
			    <span style='text-align:justify;' class='text-justify'>Kao krajnji očekivani rezultat Davalac usluga garantuje da će zaposleni, učesnici u programu biti osposobljeni za:</span>
			    <ol>
				   <li>Traženje novih potencijalnih klijenata.</li>
				   <li>Zadržavanje postojećih i produžavanje ugovora.</li>
				   <li>Nova prodaja postojećim klijentima.</li>
				   <li>Donošenje <i>&ldquor;lidova&rdquo;</i> kontakata koji će se kasnije obrađivati.</li>
				   <li>Napraviti fokus na mala i srednja preduzeća ali razvijati potreban Stav, Ponašanje i Tehnike koje će nam omogućiti da budemo fokusirani i na velike kompanije.</li>
			    </ol>",
    ]);
});
/* Article Factory - Article 4 */
$factory->defineAs(App\Article::class, '4', function ($faker) use ($factory) {
    $article = $factory->raw(App\Article::class);
    return array_merge($article, [
        'id' => 4,
        'name' => 'Mesto održavanja - Član 2',
        'html' => "<b>Mesto održavanja projekta Predsednički Klub:</b>&nbsp;",
    ]);
});
/* Article Factory - Article 5 */
$factory->defineAs(App\Article::class, '5', function ($faker) use ($factory) {
    $article = $factory->raw(App\Article::class);
    return array_merge($article, [
        'id' => 5,
        'name' => 'Broj časova - Član 2',
        'html' => "<b>Ukupan broj časova:</b>&nbsp;",
    ]);
});
/* Article Factory - Article 6 */
$factory->defineAs(App\Article::class, '6', function ($faker) use ($factory) {
    $article = $factory->raw(App\Article::class);
    return array_merge($article, [
        'id' => 6,
        'name' => 'Početak i Kraj - Član 2',
        'html' => "<b>Početak i očekivani završetak projekta:</b>&nbsp;",
    ]);
});
/* Article Factory - Article 7 */
$factory->defineAs(App\Article::class, '7', function ($faker) use ($factory) {
    $article = $factory->raw(App\Article::class);
    return array_merge($article, [
        'id' => 7,
        'name' => 'Dinamika rada - Član 2',
        'html' => "<b>Dinamika rada:</b>&nbsp;",
    ]);
});
/* Article Factory - Article 8 */
$factory->defineAs(App\Article::class, '8', function ($faker) use ($factory) {
    $article = $factory->raw(App\Article::class);
    return array_merge($article, [
        'id' => 8,
        'name' => 'Vreme održavanja - Član 2',
        'html' => "<b>Vreme održavanja:</b>&nbsp;",
    ]);
});
/* Article Factory - Article 9 */
$factory->defineAs(App\Article::class, '9', function ($faker) use ($factory) {
    $article = $factory->raw(App\Article::class);
    return array_merge($article, [
        'id' => 9,
        'name' => 'Učesnici - Član 2',
        'html' => "<b>Broj imena učesnika programa:</b>&nbsp;dat je u Prilogu 1 ovog ugovora, i predstavlja njegov sastavni i obavezujući deo",
    ]);
});
/* Article Factory - Article 10 */
$factory->defineAs(App\Article::class, '10', function ($faker) use ($factory) {
    $article = $factory->raw(App\Article::class);
    return array_merge($article, [
        'id' => 10,
        'name' => 'Dogovor - Član 2',
        'html' => "<br><p style='text-align:justify;' class='text-justify'>Promena termina je moguća zbog poslovnih obaveza kako Korisnika usluga, tako i Davaoca usluga i ugovorne strane su dužne da jedna drugu na vreme obaveste o mogućoj promeni termina.</p>
			<span>Strane su saglasne da je Davalac usluga dužan da obezbedi :</span>
			<ol>
				<li>kvalitet nastave na profesionalnom nivou i po važećim standardima u toj oblasti koji važe kako u Srbiji, tako i u svetu, kao i po zahtevima korisnika usluga,</li>
				<li>odgovarajući materijala za praćenje nastave</li>
			</ol>",
    ]);
});
/* Article Factory - Article 11 */
$factory->defineAs(App\Article::class, '11', function ($faker) use ($factory) {
    $article = $factory->raw(App\Article::class);
    return array_merge($article, [
        'id' => 11,
        'name' => 'Članovi 3, 4 i 5',
        'html' => "<p style='text-align:center;' class='text-center'><b>Član 3.</b></p>
				<p class='text-justify'>Davalac usluga se obavezuje da će u narednom periodu od momenta održavanja projekta &ldquor;Predsednički Klub&rdquo; biti dostupan za konsultacije i savete korisnicima programa &ldquor;Predsednički Klub&rdquo;. Takođe se obavezuje da će svojim profesionalnim znanjem i veštinama na bilo koji način pomoći da se stečena znanja i veštine što kvalitetnije implementiraju u poslovni proces, a sve u cilju povećanja performansi primaoca usluga - klijenta.</p>
				<br>
				<p style='text-align:center;' class='text-center'><b>Član 4.</b></p>
				<p class='text-justify'>Davalac usluga se obavezuje na Profesionalnu tajnu ćutanja, u pogledu svih informacija koje dobije od učesnika programa a vezane su za kompaniju i poslovne procese korisnika usluga.</p>
				<br>
				<p style='text-align:center;' class='text-center'><b>Član 5.</b></p>
				<p class='text-justify'>Korisnik usluga se obavezuje da će obezbediti učesnicima da prisustvuju projektu &ldquor;Predsednički Klub&rdquo; u dogovorenim terminima iz člana 2 Ugovora, kao i da za ugovorene usluge na račun Davaoca usluga uplati iznos od ",
    ]);
});
/* Article Factory - Article 12 */
$factory->defineAs(App\Article::class, '12', function ($faker) use ($factory) {
    $article = $factory->raw(App\Article::class);
    return array_merge($article, [
        'id' => 12,
        'name' => 'Plaćanje - Član 5',
        'html' => "<p class='text-justify'>Plaćanje se vrši u dinarskoj protivvrednosti koja se obračunava prema srednjem kursu NBS na dan plaćanja, a na osnovu fakture koju dostavlja Davalac usluge prema utvrđenoj dinamici.</p>",
    ]);
});
/* Article Factory - Article 13 */
$factory->defineAs(App\Article::class, '13', function ($faker) use ($factory) {
    $article = $factory->raw(App\Article::class);
    return array_merge($article, [
        'id' => 13,
        'name' => 'Članovi 6, 7 i 8',
        'html' => "<br><p style='text-align:center;' class='text-center'><b>Član 6.</b></p>
				<p style='text-align:justify;' class='text-justify'>Ugovor se zaključuje na određeno vreme do datuma završetka Projekta koji je utvrđen u članu 2 ovog ugovora.</p>
				<p style='text-align:justify;' class='text-justify'>Ugovorne strane imaju pravo jednostranog raskida, dostavljanjem drugoj strani otkaza u pisanoj formi sa otkaznim rokom od 14 dana.</p>
				<p style='text-align:justify;' class='text-justify'>Ugovorne strane zadržavaju pravo naknade štete u slučaju neizvršenja ili propuštanja jedne ugovorne strane u odnosu na drugu.</p>
				<br>
				<p style='text-align:center;' class='text-center'><b>Član 7.</b></p>
				<p style='text-align:justify;' class='text-justify'>U slučaju spora koji nije mogao biti rešen mirnim putem, nadležan je Privredni sud u Beogradu.</p>
				<br>
				<p style='text-align:center;' class='text-center'><b>Član 8.</b></p>
				<p style='text-align:justify;' class='text-justify'>Ugovor je sačinjen u 4 (četiri) identično potpisana i overena primerka, od kojih svaka strana zadržava po 2 (dva).</p>",
    ]);
});
/* Article Factory - Article 14 */
$factory->defineAs(App\Article::class, '14', function ($faker) use ($factory) {
    $article = $factory->raw(App\Article::class);
    return array_merge($article, [
        'id' => 14,
        'name' => 'Potpisi',
        'html' => "<br><br><div style='overflow:hidden' class='container-fluid'>
			   <div class='row'>
			   <div style='text-align:center;float:left' class='col-xs-4 pull-left text-center'>
			   <div style='border-bottom: 1px solid #000;height: 80px;' class='signature'>Za Davaoca usluga</div><span>Ovlašćeni zastupnik</span><br><span>...</span></div>
			   <div style='text-align:center;float:right' class='col-xs-4 pull-right text-center'>
			   <div style='border-bottom: 1px solid #000;height: 80px;' class='signature'>Za Korisnika usluga</div><span>Ovlašćeni zastupnik</span><br><span>...</span></div></div></div>
			   <br><br><br><br>",
    ]);
});
/* Article Factory - Article 15*/
$factory->defineAs(App\Article::class, '15', function ($faker) use ($factory) {
    $article = $factory->raw(App\Article::class);
    return array_merge($article, [
        'id' => 15,
        'name' => 'Prilog',
        'html' => "<h4 class='new-page'>PRILOG 1 <br> UGOVORA O PRUŽANJU USLUGA </h4>
			  <p>Broj i imena učesnika programa:</p>
			  <ol><li>...</li><li>...</li><li>...</li></ol>
			  <p>..., kao Korisnik usluga ima pravo da izvrši zamenu učesnika i obavezu da o tome unapred obavesti Davaoca usluga, što će biti konstatovano izmenom ovog priloga.</p>",
    ]);
});
