@php use Carbon\Carbon; @endphp

<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Grupo AFS - Formulario Anexo I</title>
    <link rel="stylesheet" type="text/css" href="{{asset('css/bootstrap.min.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('css/choices.min.css')}}">
    <script type="text/javascript" src="{{asset('js/jquery-3.3.1.min.js')}}"></script>
    <script type="text/javascript" src="{{asset('js/bootstrap.min.js')}}"></script>
    <script type="text/javascript" src="{{asset('js/signature_pad.umd.min.js')}}"></script>
</head>
<body class="bg-light">
<form id="form" class="my-5" method="post" action="{{url('sepe')}}">
    <div class="container-fluid">
        <div class="row">
            <div
                class="col-xl-8 offset-xl-2 col-lg-10 offset-lg-1 col-12 offset-0 px-lg-5 px-3 py-4 mb-4 rounded alert alert-light">
                <h1 class="text-center mb-5">Datos Personales</h1>
                {{csrf_field()}}
                @if ($errors->any())
                    <div class="alert alert-danger" role="alert">
                        <h5 class="alert-heading">¡Oops! Ha habido un error:</h5>
                        <ul class="mb-0">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-lg-6 col-12 mb-4">
                            <label for="name" class="form-label">Nombre/s*</label>
                            <input type="text" id="name" name="name" class="form-control" required>
                        </div>
                        <div class="col-lg-6 col-12 mb-4">
                            <label for="firstSurname" class="form-label">Primer apellido*</label>
                            <input type="text" name="firstSurname" id="firstSurname" class="form-control" required>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-6 col-12 mb-4">
                            <label for="secondSurname" class="form-label">Segundo apellido*</label>
                            <input type="text" name="secondSurname" id="secondSurname" class="form-control" required>
                        </div>
                        <div class="col-lg-6 col-12 mb-4">
                            <label for="nif" class="form-label">Nº documento identidad*</label>
                            <input id="nif" type="text" name="nif" class="form-control" required>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12 mb-4">
                            <fieldset id="genderGroup">
                                <legend class="col-form-label pt-0">Género*</legend>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="gender" value="Masculino"
                                           id="gender1" required>
                                    <label class="form-check-label" for="gender1">Masculino</label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="gender" value="Femenino"
                                           id="gender2" required>
                                    <label class="form-check-label" for="gender2">Femenino</label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="gender" value="No binario"
                                           id="gender3" required>
                                    <label class="form-check-label" for="gender3">No binario</label>
                                </div>
                            </fieldset>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-6 col-12 mb-4">
                            <label for="address" class="form-label">Dirección*</label>
                            <input id="address" type="text" class="form-control" name="address" required>
                        </div>
                        <div class="col-lg-6 col-12 mb-4">
                            <label for="locality" class="form-label">Localidad*</label>
                            <input id="locality" type="text" class="form-control" name="locality" required>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-6 col-12 mb-4">
                            <label for="postalCode" class="form-label">Código Postal*</label>
                            <input id="postalCode" type="number" min="10000" max="52999" class="form-control"
                                   name="postalCode" required>
                        </div>
                        <div class="col-lg-6 col-12 mb-4">
                            <label for="province" class="form-label">Provincia*</label>
                            <select id="province" name="province" class="form-control">
                                <option value="">Elige Provincia</option>
                                <option value="Álava">Álava/Araba</option>
                                <option value="Albacete">Albacete</option>
                                <option value="Alicante">Alicante</option>
                                <option value="Almería">Almería</option>
                                <option value="Asturias">Asturias</option>
                                <option value="Ávila">Ávila</option>
                                <option value="Badajoz">Badajoz</option>
                                <option value="Baleares">Baleares</option>
                                <option value="Barcelona">Barcelona</option>
                                <option value="Burgos">Burgos</option>
                                <option value="Cáceres">Cáceres</option>
                                <option value="Cádiz">Cádiz</option>
                                <option value="Cantabria">Cantabria</option>
                                <option value="Castellón">Castellón</option>
                                <option value="Ceuta">Ceuta</option>
                                <option value="Ciudad Real">Ciudad Real</option>
                                <option value="Córdoba">Córdoba</option>
                                <option value="Cuenca">Cuenca</option>
                                <option value="Gerona">Gerona/Girona</option>
                                <option value="Granada">Granada</option>
                                <option value="Guadalajara">Guadalajara</option>
                                <option value="Guipúzcoa">Guipúzcoa/Gipuzkoa</option>
                                <option value="Huelva">Huelva</option>
                                <option value="Huesca">Huesca</option>
                                <option value="Jaén">Jaén</option>
                                <option value="La Coruña">La Coruña/A Coruña</option>
                                <option value="La Rioja">La Rioja</option>
                                <option value="Las Palmas">Las Palmas</option>
                                <option value="León">León</option>
                                <option value="Lérida/Lleida">Lérida/Lleida</option>
                                <option value="Lugo">Lugo</option>
                                <option value="Madrid">Madrid</option>
                                <option value="Málaga">Málaga</option>
                                <option value="Melilla">Melilla</option>
                                <option value="Murcia">Murcia</option>
                                <option value="Navarra">Navarra</option>
                                <option value="Orense">Orense/Ourense</option>
                                <option value="Palencia">Palencia</option>
                                <option value="Pontevedra">Pontevedra</option>
                                <option value="Salamanca">Salamanca</option>
                                <option value="Segovia">Segovia</option>
                                <option value="Sevilla">Sevilla</option>
                                <option value="Soria">Soria</option>
                                <option value="Tarragona">Tarragona</option>
                                <option value="Tenerife">Tenerife</option>
                                <option value="Teruel">Teruel</option>
                                <option value="Toledo">Toledo</option>
                                <option value="Valencia">Valencia</option>
                                <option value="Valladolid">Valladolid</option>
                                <option value="Vizcaya">Vizcaya/Bizkaia</option>
                                <option value="Zamora">Zamora</option>
                                <option value="Zaragoza">Zaragoza</option>
                            </select>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-6 col-12 mb-4">
                            <label for="phone" class="form-label">Teléfono*</label>
                            <input id="phone" type="tel" name="phone" class="form-control" required>
                        </div>
                        <div class="col-lg-6 col-12 mb-4">
                            <label for="email" class="form-label">Email*</label>
                            <input id="email" type="email" name="email" class="form-control" required>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-6 col-12 mb-4">
                            <label for="birthdate" class="form-label">Fecha de nacimiento*</label>
                            <input
                                id="birthdate"
                                type="date"
                                name="birthdate"
                                class="form-control"
                                min="{{ Carbon::now()->subYears(150)->toDateString() }}"
                                max="{{ Carbon::now()->subYears(16)->toDateString() }}"
                                required
                            >
                        </div>
                        <div class="col-lg-6 col-12 mb-4">
                            <label for="ssnumber" class="form-label">Nº de afiliación a la Seguridad Social*</label>
                            <input id="ssnumber" inputmode="numeric" type="text" pattern="[0-9]*" name="ssnumber" class="form-control" required>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12 mb-4">
                            <fieldset id="disabilityGroup">
                                <legend class="col-form-label pt-0">¿Es usted discapacitado?*</legend>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="disability" value="1"
                                           id="disability1" required>
                                    <label class="form-check-label" for="disability1">Sí</label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="disability" value="0"
                                           id="disability2" required>
                                    <label class="form-check-label" for="disability2">No</label>
                                </div>
                            </fieldset>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-6 col-12 mb-4">
                            <label for="studyLevel" class="form-label">Estudios*</label>
                            <select id="studyLevel" name="studyLevel" class="form-control">
                                <option disabled selected value="">Selecciona el nivel de estudios (nivel máximo
                                    alcanzado)
                                </option>
                                <option value="0">0 - Sin titulación.</option>
                                <option value="1">1 - Educación Primaria.</option>
                                <option value="22">22 - Título de Graduado E.S.O. / E.G.B.</option>
                                <option value="23">23 - Certificados de Profesionalidad Nivel 1.</option>
                                <option value="24">24 - Certificados de Profesionalidad Nivel 2.</option>
                                <option value="32">32 - Bachillerato.</option>
                                <option value="33">33 - Enseñanzas de Formación Profesional de Grado Medio.</option>
                                <option value="34">34 - Enseñanzas Profesionales de Música-danza.</option>
                                <option value="38">38 - Formación Profesional Básica.</option>
                                <option value="41">41 - Certificados de Profesionalidad Nivel 3.</option>
                                <option value="51">51 - Enseñanzas de Formación Profesional de Grado Superior.</option>
                                <option value="61">61 - Grados Universitarios de hasta 240 créditos.</option>
                                <option value="62">62 - Diplomados Universitarios.</option>
                                <option value="71">71 - Grados Universitarios de más 240 créditos.</option>
                                <option value="72">72 - Licenciados o equivalentes.</option>
                                <option value="73">73 - Másteres oficiales Universitarios.</option>
                                <option value="74">74 - Especialidades en CC. Salud (residentes).</option>
                                <option value="81">81 - Doctorado Universitario.</option>
                            </select>
                        </div>
                        <div class="col-lg-6 col-12 mb-4">
                            <label for="contributionGroup" class="form-label">Grupo de Cotización*</label>
                            <select id="contributionGroup" name="contributionGroup" class="form-control" required>
                                <option disabled selected value="">Selecciona el grupo de cotización</option>
                                <option value="01">01 - Ingenieros y Licenciados. Personal de alta dirección no incluido
                                    en el artículo 1.3.c) del Estatuto de los Trabajadores.
                                </option>
                                <option value="02">02 - Ingenieros Técnicos, Peritos y Ayudantes titulados.</option>
                                <option value="03">03 - Jefes administrativos y de Taller.</option>
                                <option value="04">04 - Ayudantes no Titulados.</option>
                                <option value="05">05 - Oficiales Administrativos.</option>
                                <option value="06">06 - Subalternos.</option>
                                <option value="07">07 - Auxiliares Administrativos.</option>
                                <option value="08">08 - Oficiales de primera y segunda.</option>
                                <option value="09">09 - Oficiales de tercera y Especialistas.</option>
                                <option value="10">10 - Peones.</option>
                                <option value="11">11 - Trabajadores menores de dieciocho años cualquiera que sea su
                                    categoría profesional.
                                </option>
                            </select>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-6 col-12 mb-4">
                            <label for="otherQualification" class="form-label">Otra Titulación</label>
                            <select id="otherQualification" name="otherQualification" class="form-control" required>
                                <option value="" selected>Selecciona una titulación</option>
                                <option value="PR">PR - Carnet profesional / Profesiones Reguladas.</option>
                                <option value="A1">A1 - Nivel de idioma A1 del MCER.</option>
                                <option value="A2">A2 - Nivel de idioma A2 del MCER.</option>
                                <option value="B1">B1 - Nivel de idioma B1 del MCER.</option>
                                <option value="B2">B2 - Nivel de idioma B2 del MCER.</option>
                                <option value="C1">C1 - Nivel de idioma C1 del MCER.</option>
                                <option value="C2">C2 - Nivel de idioma C2 del MCER.</option>
                                <option value="ZZ">ZZ - Otra: (Tendrá que especificarla a continuación)</option>
                            </select>
                        </div>
                        <div class="col-lg-6 col-12 mb-4">
                            <label for="cno" class="form-label">Ocupación* (Si está desempleado, indicar la última
                                ocupación)</label>
                            <select id="cno" name="cno" class="form-control" required>
                                <option disabled selected value="">Selecciona una categoría profesional</option>
                                <option value="0011">Oficiales de las fuerzas armadas</option>
                                <option value="0012">Suboficiales de las fuerzas armadas</option>
                                <option value="0020">Tropa y marineria de las fuerzas armadas</option>
                                <option value="1111">Miembros del poder ejecutivo (nacional, autonomico y local) y del
                                    poder legislativo
                                </option>
                                <option value="1112">Personal directivo de la Administracion Publica</option>
                                <option value="1113">Directores de organizaciones de interes social</option>
                                <option value="1120">Directores generales y presidentes ejecutivos</option>
                                <option value="1211">Directores financieros</option>
                                <option value="1212">Directores de recursos humanos</option>
                                <option value="1219">Directores de politicas y planificacion y de otros departamentos
                                    administrativos no clasificados bajo otros epigrafes
                                </option>
                                <option value="1221">Directores comerciales y de ventas</option>
                                <option value="1222">Directores de publicidad y relaciones publicas</option>
                                <option value="1223">Directores de investigacion y desarrollo</option>
                                <option value="1311">Directores de produccion de explotaciones agropecuarias y
                                    forestales
                                </option>
                                <option value="1312">Directores de produccion de explotaciones pesqueras y acuicolas
                                </option>
                                <option value="1313">Directores de industrias manufactureras</option>
                                <option value="1314">Directores de explotaciones mineras</option>
                                <option value="1315">Directores de empresas de abastecimiento, transporte, distribucion
                                    y afines
                                </option>
                                <option value="1316">Directores de empresas de construccion</option>
                                <option value="1321">Directores de servicios de tecnologias de la informacion y las
                                    comunicaciones (TIC)
                                </option>
                                <option value="1322">Directores de servicios sociales para ninos</option>
                                <option value="1323">Directores-gerentes de centros sanitarios</option>
                                <option value="1324">Directores de servicios sociales para personas mayores</option>
                                <option value="1325">Directores de otros servicios sociales</option>
                                <option value="1326">Directores de servicios de educacion</option>
                                <option value="1327">Directores de sucursales de bancos, de servicios financieros y de
                                    seguros
                                </option>
                                <option value="1329">Directores de otras empresas de servicios profesionales no
                                    clasificados bajo otros epigrafes
                                </option>
                                <option value="1411">Directores y gerentes de hoteles</option>
                                <option value="1419">Directores y gerentes de otras empresas de servicios de
                                    alojamiento
                                </option>
                                <option value="1421">Directores y gerentes de restaurantes</option>
                                <option value="1422">Directores y gerentes de bares, cafeterias y similares</option>
                                <option value="1429">Directores y gerentes de empresas de catering y otras empresas de
                                    restauracion
                                </option>
                                <option value="1431">Directores y gerentes de empresas de comercio al por mayor</option>
                                <option value="1432">Directores y gerentes de empresas de comercio al por menor</option>
                                <option value="1501">Directores y gerentes de empresas de actividades recreativas,
                                    culturales y deportivas
                                </option>
                                <option value="1509">Directores y gerentes de empresas de gestion de residuos y de otras
                                    empresas de servicios no clasificados bajo otros epigrafes
                                </option>
                                <option value="2111">Medicos de familia</option>
                                <option value="2112">Otros medicos especialistas</option>
                                <option value="2121">Enfermeros no especializados</option>
                                <option value="2122">Enfermeros especializados (excepto matronos)</option>
                                <option value="2123">Matronos</option>
                                <option value="2130">Veterinarios</option>
                                <option value="2140">Farmaceuticos</option>
                                <option value="2151">Odontologos y estomatologos</option>
                                <option value="2152">Fisioterapeutas</option>
                                <option value="2153">Dietistas y nutricionistas</option>
                                <option value="2154">Logopedas</option>
                                <option value="2155">Opticos-optometristas</option>
                                <option value="2156">Terapeutas ocupacionales</option>
                                <option value="2157">Podologos</option>
                                <option value="2158">Profesionales de la salud y la higiene laboral y ambiental</option>
                                <option value="2159">Profesionales de la salud no clasificados bajo otros epigrafes
                                </option>
                                <option value="2210">Profesores de universidades y otra ensenanza superior (excepto
                                    formacion profesional)
                                </option>
                                <option value="2220">Profesores de formacion profesional (materias especificas)</option>
                                <option value="2230">Profesores de ensenanza secundaria (excepto materias especificas de
                                    formacion profesional)
                                </option>
                                <option value="2240">Profesores de ensenanza primaria</option>
                                <option value="2251">Maestros de educacion infantil</option>
                                <option value="2252">Tecnicos en educacion infantil</option>
                                <option value="2311">Profesores de educacion especial</option>
                                <option value="2312">Tecnicos educadores de educacion especial</option>
                                <option value="2321">Especialistas en metodos didacticos y pedagogicos</option>
                                <option value="2322">Profesores de ensenanza no reglada de idiomas</option>
                                <option value="2323">Profesores de ensenanza no reglada de musica y danza</option>
                                <option value="2324">Profesores de ensenanza no reglada de artes</option>
                                <option value="2325">Instructores en tecnologias de la informacion en ensenanza no
                                    reglada
                                </option>
                                <option value="2326">Profesionales de la educacion ambiental</option>
                                <option value="2329">Profesores y profesionales de la ensenanza no clasificados bajo
                                    otros epigrafes
                                </option>
                                <option value="2411">Fisicos y astronomos</option>
                                <option value="2412">Meteorologos</option>
                                <option value="2413">Quimicos</option>
                                <option value="2414">Geologos y geofisicos</option>
                                <option value="2415">Matematicos y actuarios</option>
                                <option value="2416">Estadisticos</option>
                                <option value="2421">Biologos, botanicos, zoologos y afines</option>
                                <option value="2422">Ingenieros agronomos</option>
                                <option value="2423">Ingenieros de montes</option>
                                <option value="2424">Ingenieros tecnicos agricolas</option>
                                <option value="2425">Ingenieros tecnicos forestales y del medio natural</option>
                                <option value="2426">Profesionales de la proteccion ambiental</option>
                                <option value="2427">Enologos</option>
                                <option value="2431">Ingenieros industriales y de produccion</option>
                                <option value="2432">Ingenieros en construccion y obra civil</option>
                                <option value="2433">Ingenieros mecanicos</option>
                                <option value="2434">Ingenieros aeronauticos</option>
                                <option value="2435">Ingenieros quimicos</option>
                                <option value="2436">Ingenieros de minas, metalurgicos y afines</option>
                                <option value="2437">Ingenieros ambientales</option>
                                <option value="2439">Ingenieros no clasificados bajo otros epigrafes</option>
                                <option value="2441">Ingenieros en electricidad</option>
                                <option value="2442">Ingenieros electronicos</option>
                                <option value="2443">Ingenieros en telecomunicaciones</option>
                                <option value="2451">Arquitectos (excepto arquitectos paisajistas y urbanistas)</option>
                                <option value="2452">Arquitectos paisajistas</option>
                                <option value="2453">Urbanistas e ingenieros de trafico</option>
                                <option value="2454">Ingenieros geografos y cartografos</option>
                                <option value="2461">Ingenieros tecnicos industriales y de produccion</option>
                                <option value="2462">Ingenieros tecnicos de obras publicas</option>
                                <option value="2463">Ingenieros tecnicos mecanicos</option>
                                <option value="2464">Ingenieros tecnicos aeronauticos</option>
                                <option value="2465">Ingenieros tecnicos quimicos</option>
                                <option value="2466">Ingenieros tecnicos de minas, metalurgicos y afines</option>
                                <option value="2469">Ingenieros tecnicos no clasificados bajo otros epigrafes</option>
                                <option value="2471">Ingenieros tecnicos en electricidad</option>
                                <option value="2472">Ingenieros tecnicos en electronica</option>
                                <option value="2473">Ingenieros tecnicos en telecomunicaciones</option>
                                <option value="2481">Arquitectos tecnicos y tecnicos urbanistas</option>
                                <option value="2482">Disenadores de productos y de prendas</option>
                                <option value="2483">Ingenieros tecnicos en topografia</option>
                                <option value="2484">Disenadores graficos y multimedia</option>
                                <option value="2511">Abogados</option>
                                <option value="2512">Fiscales</option>
                                <option value="2513">Jueces y magistrados</option>
                                <option value="2591">Notarios y registradores</option>
                                <option value="2592">Procuradores</option>
                                <option value="2599">Profesionales del derecho no clasificados bajo otros epigrafes
                                </option>
                                <option value="2611">Especialistas en contabilidad</option>
                                <option value="2612">Asesores financieros y en inversiones</option>
                                <option value="2613">Analistas financieros</option>
                                <option value="2621">Analistas de gestion y organizacion</option>
                                <option value="2622">Especialistas en administracion de politica de empresas</option>
                                <option value="2623">Especialistas de la Administracion Publica</option>
                                <option value="2624">Especialistas en politicas y servicios de personal y afines
                                </option>
                                <option value="2625">Especialistas en formacion de personal</option>
                                <option value="2630">Tecnicos de empresas y actividades turisticas</option>
                                <option value="2640">Profesionales de ventas tecnicas y medicas (excepto las TIC)
                                </option>
                                <option value="2651">Profesionales de la publicidad y la comercializacion</option>
                                <option value="2652">Profesionales de relaciones publicas</option>
                                <option value="2653">Profesionales de la venta de tecnologias de la informacion y las
                                    comunicaciones
                                </option>
                                <option value="2711">Analistas de sistemas</option>
                                <option value="2712">Analistas y disenadores de software</option>
                                <option value="2713">Analistas, programadores y disenadores Web y multimedia</option>
                                <option value="2719">Analistas y disenadores de software y multimedia no clasificados
                                    bajo otros epigrafes
                                </option>
                                <option value="2721">Disenadores y administradores de bases de datos</option>
                                <option value="2722">Administradores de sistemas y redes</option>
                                <option value="2723">Analistas de redes informaticas</option>
                                <option value="2729">Especialistas en bases de datos y en redes informaticas no
                                    clasificados bajo otros epigrafes
                                </option>
                                <option value="2810">Economistas</option>
                                <option value="2821">Sociologos, geografos, antropologos, arqueologos y afines</option>
                                <option value="2822">Filosofos, historiadores y profesionales en ciencias politicas
                                </option>
                                <option value="2823">Psicologos</option>
                                <option value="2824">Profesionales del trabajo y la educacion social</option>
                                <option value="2825">Agentes de igualdad de oportunidades entre mujeres y hombres
                                </option>
                                <option value="2830">Sacerdotes de las distintas religiones</option>
                                <option value="2911">Archivistas y conservadores de museos</option>
                                <option value="2912">Bibliotecarios, documentalistas y afines</option>
                                <option value="2921">Escritores</option>
                                <option value="2922">Periodistas</option>
                                <option value="2923">Filologos, interpretes y traductores</option>
                                <option value="2931">Artistas de artes plasticas y visuales</option>
                                <option value="2932">Compositores, musicos y cantantes</option>
                                <option value="2933">Coreografos y bailarines</option>
                                <option value="2934">Directores de cine, de teatro y afines</option>
                                <option value="2935">Actores</option>
                                <option value="2936">Locutores de radio, television y otros presentadores</option>
                                <option value="2937">Profesionales de espectaculos taurinos</option>
                                <option value="2939">Artistas creativos e interpretativos no clasificados bajo otros
                                    epigrafes
                                </option>
                                <option value="3110">Delineantes y dibujantes tecnicos</option>
                                <option value="3121">Tecnicos en ciencias fisicas y quimicas</option>
                                <option value="3122">Tecnicos en construccion</option>
                                <option value="3123">Tecnicos en electricidad</option>
                                <option value="3124">Tecnicos en electronica (excepto electromedicina)</option>
                                <option value="3125">Tecnicos en electronica, especialidad en electromedicina</option>
                                <option value="3126">Tecnicos en mecanica</option>
                                <option value="3127">Tecnicos y analistas de laboratorio en quimica industrial</option>
                                <option value="3128">Tecnicos en metalurgia y minas</option>
                                <option value="3129">Otros tecnicos de las ciencias fisicas, quimicas, medioambientales
                                    y de las ingenierias
                                </option>
                                <option value="3131">Tecnicos en instalaciones de produccion de energia</option>
                                <option value="3132">Tecnicos en instalaciones de tratamiento de residuos, de aguas y
                                    otros operadores en plantas similares
                                </option>
                                <option value="3133">Tecnicos en control de instalaciones de procesamiento de productos
                                    quimicos
                                </option>
                                <option value="3134">Tecnicos de refinerias de petroleo y gas natural</option>
                                <option value="3135">Tecnicos en control de procesos de produccion de metales</option>
                                <option value="3139">Tecnicos en control de procesos no clasificados bajo otros
                                    epigrafes
                                </option>
                                <option value="3141">Tecnicos en ciencias biologicas (excepto en areas sanitarias)
                                </option>
                                <option value="3142">Tecnicos agropecuarios</option>
                                <option value="3143">Tecnicos forestales y del medio natural</option>
                                <option value="3151">Jefes y oficiales de maquinas</option>
                                <option value="3152">Capitanes y oficiales de puente</option>
                                <option value="3153">Pilotos de aviacion y profesionales afines</option>
                                <option value="3154">Controladores de trafico aereo</option>
                                <option value="3155">Tecnicos en seguridad aeronautica</option>
                                <option value="3160">Tecnicos de control de calidad de las ciencias fisicas, quimicas y
                                    de las ingenierias
                                </option>
                                <option value="3201">Supervisores en ingenieria de minas</option>
                                <option value="3202">Supervisores de la construccion</option>
                                <option value="3203">Supervisores de industrias alimenticias y del tabaco</option>
                                <option value="3204">Supervisores de industrias quimica y farmaceutica</option>
                                <option value="3205">Supervisores de industrias de transformacion de plasticos, caucho y
                                    resinas naturales
                                </option>
                                <option value="3206">Supervisores de industrias de la madera y pastero papeleras
                                </option>
                                <option value="3207">Supervisores de la produccion en industrias de artes graficas y en
                                    la fabricacion de productos de papel
                                </option>
                                <option value="3209">Supervisores de otras industrias manufactureras</option>
                                <option value="3311">Tecnicos en radioterapia</option>
                                <option value="3312">Tecnicos en imagen para el diagnostico</option>
                                <option value="3313">Tecnicos en anatomia patologica y citologia</option>
                                <option value="3314">Tecnicos en laboratorio de diagnostico clinico</option>
                                <option value="3315">Tecnicos en ortoprotesis</option>
                                <option value="3316">Tecnicos en protesis dentales</option>
                                <option value="3317">Tecnicos en audioprotesis</option>
                                <option value="3321">Tecnicos superiores en higiene bucodental</option>
                                <option value="3322">Tecnicos superiores en documentacion sanitaria</option>
                                <option value="3323">Tecnicos superiores en dietetica</option>
                                <option value="3324">Tecnicos en optometria</option>
                                <option value="3325">Ayudantes fisioterapeutas</option>
                                <option value="3326">Tecnicos en prevencion de riesgos laborales y salud ambiental
                                </option>
                                <option value="3327">Ayudantes de veterinaria</option>
                                <option value="3329">Tecnicos de la sanidad no clasificados bajo otros epigrafes
                                </option>
                                <option value="3331">Profesionales de la acupuntura, la naturopatia, la homeopatia, la
                                    medicina tradicional china y la ayurveda
                                </option>
                                <option value="3339">Otros profesionales de las terapias alternativas</option>
                                <option value="3401">Profesionales de apoyo e intermediarios de cambio, bolsa y
                                    finanzas
                                </option>
                                <option value="3402">Comerciales de prestamos y creditos</option>
                                <option value="3403">Tenedores de libros</option>
                                <option value="3404">Profesionales de apoyo en servicios estadisticos, matematicos y
                                    afines
                                </option>
                                <option value="3405">Tasadores</option>
                                <option value="3510">Agentes y representantes comerciales</option>
                                <option value="3521">Mediadores y agentes de seguros</option>
                                <option value="3522">Agentes de compras</option>
                                <option value="3523">Consignatarios</option>
                                <option value="3531">Representantes de aduanas</option>
                                <option value="3532">Organizadores de conferencias y eventos</option>
                                <option value="3533">Agentes o intermediarios en la contratacion de la mano de obra
                                    (excepto representantes de espectaculos)
                                </option>
                                <option value="3534">Agentes y administradores de la propiedad inmobiliaria</option>
                                <option value="3535">Portavoces y agentes de relaciones publicas</option>
                                <option value="3539">Representantes artisticos y deportivos y otros agentes de servicios
                                    comerciales no clasificados bajo otros epigrafes
                                </option>
                                <option value="3611">Supervisores de secretaria</option>
                                <option value="3612">Asistentes juridico-legales</option>
                                <option value="3613">Asistentes de direccion y administrativos</option>
                                <option value="3614">Secretarios de centros medicos o clinicas</option>
                                <option value="3621">Profesionales de apoyo de la Administracion Publica de tributos
                                </option>
                                <option value="3622">Profesionales de apoyo de la Administracion Publica de servicios
                                    sociales
                                </option>
                                <option value="3623">Profesionales de apoyo de la Administracion Publica de servicios de
                                    expedicion de licencias
                                </option>
                                <option value="3629">Otros profesionales de apoyo de la Administracion Publica para
                                    tareas de inspeccion y control y tareas similares
                                </option>
                                <option value="3631">Tecnicos de la policia nacional, autonomica y local</option>
                                <option value="3632">Suboficiales de la guardia civil</option>
                                <option value="3711">Profesionales de apoyo de servicios juridicos y servicios
                                    similares
                                </option>
                                <option value="3712">Detectives privados</option>
                                <option value="3713">Profesionales de apoyo al trabajo y a la educacion social</option>
                                <option value="3714">Promotores de igualdad de oportunidades entre mujeres y hombres
                                </option>
                                <option value="3715">Animadores comunitarios</option>
                                <option value="3716">Auxiliares laicos de las religiones</option>
                                <option value="3721">Atletas y deportistas</option>
                                <option value="3722">Entrenadores y arbitros de actividades deportivas</option>
                                <option value="3723">Instructores de actividades deportivas</option>
                                <option value="3724">Monitores de actividades recreativas y de entretenimiento</option>
                                <option value="3731">Fotografos</option>
                                <option value="3732">Disenadores y decoradores de interior</option>
                                <option value="3733">Tecnicos en galerias de arte, museos y bibliotecas</option>
                                <option value="3734">Chefs</option>
                                <option value="3739">Otros tecnicos y profesionales de apoyo de actividades culturales y
                                    artisticas
                                </option>
                                <option value="3811">Tecnicos en operaciones de sistemas informaticos</option>
                                <option value="3812">Tecnicos en asistencia al usuario de tecnologias de la
                                    informacion
                                </option>
                                <option value="3813">Tecnicos en redes</option>
                                <option value="3814">Tecnicos de la Web</option>
                                <option value="3820">Programadores informaticos</option>
                                <option value="3831">Tecnicos de grabacion audiovisual</option>
                                <option value="3832">Tecnicos de radiodifusion</option>
                                <option value="3833">Tecnicos de ingenieria de las telecomunicaciones</option>
                                <option value="4111">Empleados de contabilidad</option>
                                <option value="4112">Empleados de control de personal y nominas</option>
                                <option value="4113">Empleados de oficina de servicios estadisticos, financieros y
                                    bancarios
                                </option>
                                <option value="4121">Empleados de control de abastecimientos e inventario</option>
                                <option value="4122">Empleados de oficina de servicios de apoyo a la produccion</option>
                                <option value="4123">Empleados de logistica y transporte de pasajeros y mercancias
                                </option>
                                <option value="4210">Empleados de bibliotecas y archivos</option>
                                <option value="4221">Empleados de servicios de correos (excepto empleados de
                                    mostrador)
                                </option>
                                <option value="4222">Codificadores y correctores de imprenta</option>
                                <option value="4223">Empleados de servicio de personal</option>
                                <option value="4301">Grabadores de datos</option>
                                <option value="4309">Empleados administrativos sin tareas de atencion al publico no
                                    clasificados bajo otros epigrafes
                                </option>
                                <option value="4411">Empleados de informacion al usuario</option>
                                <option value="4412">Recepcionistas (excepto de hoteles)</option>
                                <option value="4421">Empleados de agencias de viajes</option>
                                <option value="4422">Recepcionistas de hoteles</option>
                                <option value="4423">Telefonistas</option>
                                <option value="4424">Teleoperadores</option>
                                <option value="4430">Agentes de encuestas</option>
                                <option value="4441">Cajeros de bancos y afines</option>
                                <option value="4442">Empleados de venta de apuestas</option>
                                <option value="4443">Empleados de sala de juegos y afines</option>
                                <option value="4444">Empleados de casas de empeno y de prestamos</option>
                                <option value="4445">Cobradores de facturas, deudas y empleados afines</option>
                                <option value="4446">Empleados de mostrador de correos</option>
                                <option value="4500">Empleados administrativos con tareas de atencion al publico no
                                    clasificados bajo otros epigrafes
                                </option>
                                <option value="5000">Camareros y cocineros propietarios</option>
                                <option value="5110">Cocineros asalariados</option>
                                <option value="5120">Camareros asalariados</option>
                                <option value="5210">Jefes de seccion de tiendas y almacenes</option>
                                <option value="5220">Vendedores en tiendas y almacenes</option>
                                <option value="5300">Comerciantes propietarios de tiendas</option>
                                <option value="5411">Vendedores en quioscos</option>
                                <option value="5412">Vendedores en mercados ocasionales y mercadillos</option>
                                <option value="5420">Operadores de telemarketing</option>
                                <option value="5430">Expendedores de gasolineras</option>
                                <option value="5491">Vendedores a domicilio</option>
                                <option value="5492">Promotores de venta</option>
                                <option value="5493">Modelos de moda, arte y publicidad</option>
                                <option value="5499">Vendedores no clasificados bajo otros epigrafes</option>
                                <option value="5500">Cajeros y taquilleros (excepto bancos)</option>
                                <option value="5611">Auxiliares de enfermeria hospitalaria</option>
                                <option value="5612">Auxiliares de enfermeria de atencion primaria</option>
                                <option value="5621">Tecnicos auxiliares de farmacia</option>
                                <option value="5622">Tecnicos de emergencias sanitarias</option>
                                <option value="5629">Trabajadores de los cuidados a las personas en servicios de salud
                                    no clasificados bajo otros epigrafes
                                </option>
                                <option value="5710">Trabajadores de los cuidados personales a domicilio</option>
                                <option value="5721">Cuidadores de ninos en guarderias y centros educativos</option>
                                <option value="5722">Cuidadores de ninos en domicilios</option>
                                <option value="5811">Peluqueros</option>
                                <option value="5812">Especialistas en tratamientos de estetica, bienestar y afines
                                </option>
                                <option value="5821">Auxiliares de vuelo y camareros de avion, barco y tren</option>
                                <option value="5822">Revisores y cobradores de transporte terrestre</option>
                                <option value="5823">Acompanantes turisticos</option>
                                <option value="5824">Azafatos de tierra</option>
                                <option value="5825">Guias de turismo</option>
                                <option value="5831">Supervisores de mantenimiento y limpieza en oficinas, hoteles y
                                    otros establecimientos
                                </option>
                                <option value="5832">Mayordomos del servicio domestico</option>
                                <option value="5833">Conserjes de edificios</option>
                                <option value="5840">Trabajadores propietarios de pequenos alojamientos</option>
                                <option value="5891">Asistentes personales o personas de compania</option>
                                <option value="5892">Empleados de pompas funebres y embalsamadores</option>
                                <option value="5893">Cuidadores de animales y adiestradores</option>
                                <option value="5894">Instructores de autoescuela</option>
                                <option value="5895">Astrologos, adivinadores y afines</option>
                                <option value="5899">Trabajadores de servicios personales no clasificados bajo otros
                                    epigrafes
                                </option>
                                <option value="5910">Guardias civiles</option>
                                <option value="5921">Policias nacionales</option>
                                <option value="5922">Policias autonomicos</option>
                                <option value="5923">Policias locales</option>
                                <option value="5931">Bomberos (excepto forestales)</option>
                                <option value="5932">Bomberos forestales</option>
                                <option value="5941">Vigilantes de seguridad y similares habilitados para ir armados
                                </option>
                                <option value="5942">Auxiliares de vigilante de seguridad y similares no habilitados
                                    para ir armados
                                </option>
                                <option value="5991">Vigilantes de prisiones</option>
                                <option value="5992">Banistas-socorristas</option>
                                <option value="5993">Agentes forestales y medioambientales</option>
                                <option value="5999">Trabajadores de los servicios de proteccion y seguridad no
                                    clasificados bajo otros epigrafes
                                </option>
                                <option value="6110">Trabajadores cualificados en actividades agricolas (excepto en
                                    huertas, invernaderos, viveros y jardines)
                                </option>
                                <option value="6120">Trabajadores cualificados en huertas, invernaderos, viveros y
                                    jardines
                                </option>
                                <option value="6201">Trabajadores cualificados en actividades ganaderas de vacuno
                                </option>
                                <option value="6202">Trabajadores cualificados en actividades ganaderas de ovino y
                                    caprino
                                </option>
                                <option value="6203">Trabajadores cualificados en actividades ganaderas de porcino
                                </option>
                                <option value="6204">Trabajadores cualificados en apicultura y sericicultura</option>
                                <option value="6205">Trabajadores cualificados en la avicultura y la cunicultura
                                </option>
                                <option value="6209">Trabajadores cualificados en actividades ganaderas no clasificados
                                    bajo otros epigrafes
                                </option>
                                <option value="6300">Trabajadores cualificados en actividades agropecuarias mixtas
                                </option>
                                <option value="6410">Trabajadores cualificados en actividades forestales y del medio
                                    natural
                                </option>
                                <option value="6421">Trabajadores cualificados en la acuicultura</option>
                                <option value="6422">Pescadores de aguas costeras y aguas dulces</option>
                                <option value="6423">Pescadores de altura</option>
                                <option value="6430">Trabajadores cualificados en actividades cinegeticas</option>
                                <option value="7111">Encofradores y operarios de puesta en obra de hormigon</option>
                                <option value="7112">Montadores de prefabricados estructurales (solo hormigon)</option>
                                <option value="7121">Albaniles</option>
                                <option value="7122">Canteros, tronzadores, labrantes y grabadores de piedras</option>
                                <option value="7131">Carpinteros (excepto ebanistas)</option>
                                <option value="7132">Instaladores de cerramientos metalicos y carpinteros metalicos
                                    (excepto montadores de estructuras metalicas)
                                </option>
                                <option value="7191">Mantenedores de edificios</option>
                                <option value="7192">Instaladores de fachadas tecnicas</option>
                                <option value="7193">Instaladores de sistemas de impermeabilizacion en edificios
                                </option>
                                <option value="7199">Otros trabajadores de las obras estructurales de construccion no
                                    clasificados bajo otros epigrafes
                                </option>
                                <option value="7211">Escayolistas</option>
                                <option value="7212">Aplicadores de revestimientos de pasta y mortero</option>
                                <option value="7221">Fontaneros</option>
                                <option value="7222">Montadores-instaladores de gas en edificios</option>
                                <option value="7223">Instaladores de conductos en obra publica</option>
                                <option value="7231">Pintores y empapeladores</option>
                                <option value="7232">Pintores en las industrias manufactureras</option>
                                <option value="7240">Soladores, colocadores de parquet y afines</option>
                                <option value="7250">Mecanicos-instaladores de refrigeracion y climatizacion</option>
                                <option value="7291">Montadores de cubiertas</option>
                                <option value="7292">Instaladores de material aislante termico y de insonorizacion
                                </option>
                                <option value="7293">Cristaleros</option>
                                <option value="7294">Montadores-instaladores de placas de energia solar</option>
                                <option value="7295">Personal de limpieza de fachadas de edificios y chimeneas</option>
                                <option value="7311">Moldeadores y macheros</option>
                                <option value="7312">Soldadores y oxicortadores</option>
                                <option value="7313">Chapistas y caldereros</option>
                                <option value="7314">Montadores de estructuras metalicas</option>
                                <option value="7315">Montadores de estructuras cableadas y empalmadores de cables
                                </option>
                                <option value="7321">Herreros y forjadores</option>
                                <option value="7322">Trabajadores de la fabricacion de herramientas,
                                    mecanico-ajustadores, modelistas, matriceros y afines
                                </option>
                                <option value="7323">Ajustadores y operadores de maquinas-herramienta</option>
                                <option value="7324">Pulidores de metales y afiladores de herramientas</option>
                                <option value="7401">Mecanicos y ajustadores de vehiculos de motor</option>
                                <option value="7402">Mecanicos y ajustadores de motores de avion</option>
                                <option value="7403">Mecanicos y ajustadores de maquinaria agricola e industrial
                                </option>
                                <option value="7404">Mecanicos y ajustadores de maquinaria naval y ferroviaria</option>
                                <option value="7405">Reparadores de bicicletas y afines</option>
                                <option value="7510">Electricistas de la construccion y afines</option>
                                <option value="7521">Mecanicos y reparadores de equipos electricos</option>
                                <option value="7522">Instaladores y reparadores de lineas electricas</option>
                                <option value="7531">Mecanicos y reparadores de equipos electronicos</option>
                                <option value="7532">Instaladores y reparadores en electromedicina</option>
                                <option value="7533">Instaladores y reparadores en tecnologias de la informacion y las
                                    comunicaciones
                                </option>
                                <option value="7611">Relojeros y mecanicos de instrumentos de precision</option>
                                <option value="7612">Lutieres y similares; afinadores de instrumentos musicales</option>
                                <option value="7613">Joyeros, orfebres y plateros</option>
                                <option value="7614">Trabajadores de la ceramica, alfareros y afines</option>
                                <option value="7615">Sopladores, modeladores, laminadores, cortadores y pulidores de
                                    vidrio
                                </option>
                                <option value="7616">Rotulistas, grabadores de vidrio, pintores decorativos de articulos
                                    diversos
                                </option>
                                <option value="7617">Artesanos en madera y materiales similares; cesteros, bruceros y
                                    trabajadores afines
                                </option>
                                <option value="7618">Artesanos en tejidos, cueros y materiales similares, preparadores
                                    de fibra y tejedores con telares artesanos o de tejidos de punto y afines
                                </option>
                                <option value="7619">Artesanos no clasificados bajo otros epigrafes</option>
                                <option value="7621">Trabajadores de procesos de preimpresion</option>
                                <option value="7622">Trabajadores de procesos de impresion</option>
                                <option value="7623">Trabajadores de procesos de encuadernacion</option>
                                <option value="7701">Matarifes y trabajadores de las industrias carnicas</option>
                                <option value="7702">Trabajadores de las industrias del pescado</option>
                                <option value="7703">Panaderos, pasteleros y confiteros</option>
                                <option value="7704">Trabajadores del tratamiento de la leche y elaboracion de productos
                                    lacteos (incluidos helados)
                                </option>
                                <option value="7705">Trabajadores conserveros de frutas y hortalizas y trabajadores de
                                    la elaboracion de bebidas no alcoholicas
                                </option>
                                <option value="7706">Trabajadores de la elaboracion de bebidas alcoholicas distintas del
                                    vino
                                </option>
                                <option value="7707">Trabajadores de la elaboracion del vino</option>
                                <option value="7708">Preparadores y elaboradores del tabaco y sus productos</option>
                                <option value="7709">Catadores y clasificadores de alimentos y bebidas</option>
                                <option value="7811">Trabajadores del tratamiento de la madera</option>
                                <option value="7812">Ajustadores y operadores de maquinas para trabajar la madera
                                </option>
                                <option value="7820">Ebanistas y trabajadores afines</option>
                                <option value="7831">Sastres, modistos, peleteros y sombrereros</option>
                                <option value="7832">Patronistas para productos en textil y piel</option>
                                <option value="7833">Cortadores de tejidos, cuero, piel y otros materiales</option>
                                <option value="7834">Costureros a mano, bordadores y afines</option>
                                <option value="7835">Tapiceros, colchoneros y afines</option>
                                <option value="7836">Curtidores y preparadores de pieles</option>
                                <option value="7837">Zapateros y afines</option>
                                <option value="7891">Buceadores</option>
                                <option value="7892">Pegadores</option>
                                <option value="7893">Clasificadores y probadores de productos (excepto alimentos,
                                    bebidas y tabaco)
                                </option>
                                <option value="7894">Fumigadores y otros controladores de plagas y malas hierbas
                                </option>
                                <option value="7899">Oficiales, operarios y artesanos de otros oficios no clasificados
                                    bajo otros epigrafes
                                </option>
                                <option value="8111">Mineros y otros operadores en instalaciones mineras</option>
                                <option value="8112">Operadores en instalaciones para la preparacion de minerales y
                                    rocas
                                </option>
                                <option value="8113">Sondistas y trabajadores afines</option>
                                <option value="8114">Operadores de maquinaria para fabricar productos derivados de
                                    minerales no metalicos
                                </option>
                                <option value="8121">Operadores en instalaciones para la obtencion y transformacion de
                                    metales
                                </option>
                                <option value="8122">Operadores de maquinas pulidoras, galvanizadoras y recubridoras de
                                    metales
                                </option>
                                <option value="8131">Operadores en plantas industriales quimicas</option>
                                <option value="8132">Operadores de maquinas para fabricar productos farmaceuticos,
                                    cosmeticos y afines
                                </option>
                                <option value="8133">Operadores de laboratorios fotograficos y afines</option>
                                <option value="8141">Operadores de maquinas para fabricar productos de caucho y
                                    derivados de resinas naturales
                                </option>
                                <option value="8142">Operadores de maquinas para fabricar productos de material
                                    plastico
                                </option>
                                <option value="8143">Operadores de maquinas para fabricar productos de papel y carton
                                </option>
                                <option value="8144">Operadores de serrerias, de maquinas de fabricacion de tableros y
                                    de instalaciones afines para el tratamiento de la madera y el corcho
                                </option>
                                <option value="8145">Operadores en instalaciones para la preparacion de pasta de papel y
                                    fabricacion de papel
                                </option>
                                <option value="8151">Operadores de maquinas para preparar fibras, hilar y devanar
                                </option>
                                <option value="8152">Operadores de telares y otras maquinas tejedoras</option>
                                <option value="8153">Operadores de maquinas de coser y bordar</option>
                                <option value="8154">Operadores de maquinas de blanquear, tenir, estampar y acabar
                                    textiles
                                </option>
                                <option value="8155">Operadores de maquinas para tratar pieles y cuero</option>
                                <option value="8156">Operadores de maquinas para la fabricacion del calzado,
                                    marroquineria y guanteria de piel
                                </option>
                                <option value="8159">Operadores de maquinas para fabricar productos textiles no
                                    clasificados bajo otros epigrafes
                                </option>
                                <option value="8160">Operadores de maquinas para elaborar productos alimenticios,
                                    bebidas y tabaco
                                </option>
                                <option value="8170">Operadores de maquinas de lavanderia y tintoreria</option>
                                <option value="8191">Operadores de hornos e instalaciones de vidrieria y ceramica
                                </option>
                                <option value="8192">Operadores de calderas y maquinas de vapor</option>
                                <option value="8193">Operadores de maquinas de embalaje, embotellamiento y etiquetado
                                </option>
                                <option value="8199">Operadores de instalaciones y maquinaria fijas no clasificados bajo
                                    otros epigrafes
                                </option>
                                <option value="8201">Ensambladores de maquinaria mecanica</option>
                                <option value="8202">Ensambladores de equipos electricos y electronicos</option>
                                <option value="8209">Montadores y ensambladores no clasificados en otros epigrafes
                                </option>
                                <option value="8311">Maquinistas de locomotoras</option>
                                <option value="8312">Agentes de maniobras ferroviarias</option>
                                <option value="8321">Operadores de maquinaria agricola movil</option>
                                <option value="8322">Operadores de maquinaria forestal movil</option>
                                <option value="8331">Operadores de maquinaria de movimientos de tierras y equipos
                                    similares
                                </option>
                                <option value="8332">Operadores de gruas, montacargas y de maquinaria similar de
                                    movimiento de materiales
                                </option>
                                <option value="8333">Operadores de carretillas elevadoras</option>
                                <option value="8340">Marineros de puente, marineros de maquinas y afines</option>
                                <option value="8411">Conductores propietarios de automoviles, taxis y furgonetas
                                </option>
                                <option value="8412">Conductores asalariados de automoviles, taxis y furgonetas</option>
                                <option value="8420">Conductores de autobuses y tranvias</option>
                                <option value="8431">Conductores propietarios de camiones</option>
                                <option value="8432">Conductores asalariados de camiones</option>
                                <option value="8440">Conductores de motocicletas y ciclomotores</option>
                                <option value="9100">Empleados domesticos</option>
                                <option value="9210">Personal de limpieza de oficinas, hoteles y otros establecimientos
                                    similares
                                </option>
                                <option value="9221">Limpiadores en seco a mano y afines</option>
                                <option value="9222">Limpiadores de vehiculos</option>
                                <option value="9223">Limpiadores de ventanas</option>
                                <option value="9229">Otro personal de limpieza</option>
                                <option value="9310">Ayudantes de cocina</option>
                                <option value="9320">Preparadores de comidas rapidas</option>
                                <option value="9410">Vendedores callejeros</option>
                                <option value="9420">Repartidores de publicidad, limpiabotas y otros trabajadores de
                                    oficios callejeros
                                </option>
                                <option value="9431">Ordenanzas</option>
                                <option value="9432">Mozos de equipaje y afines</option>
                                <option value="9433">Repartidores, recadistas y mensajeros a pie</option>
                                <option value="9434">Lectores de contadores y recaudadores de maquinas recreativas y
                                    expendedoras
                                </option>
                                <option value="9441">Recogedores de residuos</option>
                                <option value="9442">Clasificadores de desechos, operarios de punto limpio y recogedores
                                    de chatarra
                                </option>
                                <option value="9443">Barrenderos y afines</option>
                                <option value="9490">Otras ocupaciones elementales</option>
                                <option value="9511">Peones agricolas (excepto en huertas, invernaderos, viveros y
                                    jardines)
                                </option>
                                <option value="9512">Peones agricolas en huertas, invernaderos, viveros y jardines
                                </option>
                                <option value="9520">Peones ganaderos</option>
                                <option value="9530">Peones agropecuarios</option>
                                <option value="9541">Peones de la pesca</option>
                                <option value="9542">Peones de la acuicultura</option>
                                <option value="9543">Peones forestales y de la caza</option>
                                <option value="9601">Peones de obras publicas</option>
                                <option value="9602">Peones de la construccion de edificios</option>
                                <option value="9603">Peones de la mineria, canteras y otras industrias extractivas
                                </option>
                                <option value="9700">Peones de las industrias manufactureras</option>
                                <option value="9811">Peones del transporte de mercancias y descargadores</option>
                                <option value="9812">Conductores de vehiculos de traccion animal para el transporte de
                                    personas y similares
                                </option>
                                <option value="9820">Reponedores</option>
                            </select>
                        </div>
                    </div>
                    <div id="zzOtherContainer" class="row d-none">
                        <div class="col-12 mb-4">
                            <label for="zzOtherText" class="form-label">Especifique su titulación*</label>
                            <input type="text" class="form-control" id="zzOtherText" name="zzOtherText">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-6 col-12 mb-4">
                            <label for="professionalCategory" class="form-label">Categoría profesional*</label>
                            <select id="professionalCategory" name="professionalCategory" class="form-control" required>
                                <option disabled selected value="">Selecciona una categoría profesional</option>
                                <option value="directivo">Directivo</option>
                                <option value="mando_intermedio">Mando Intermedio</option>
                                <option value="tecnico">Técnico</option>
                                <option value="trabajador_cualificado">Trabajador cualificado</option>
                                <option value="baja_cualificacion">Trabajador de baja cualificación (*)</option>
                            </select>
                            <div id="qualificationNote" class="alert alert-info d-none">
                                <p>
                                    <strong>(*)</strong> Grupos de cotización 06, 07, 09 o 10 de la última ocupación.
                                    En el caso de tratarse personas desempleadas, aquellas que no estén en posesión de
                                    un
                                    carnet profesional, certificado de profesionalidad de nivel 2 o 3, título de
                                    formación
                                    profesional o una titulación universitaria.
                                </p>
                            </div>
                        </div>
                        <div class="col-lg-6 col-12 mb-4">
                            <label for="participantStatus" class="form-label">Situación actual*</label>
                            <select id="participantStatus" name="participantStatus" class="form-control" required>
                                <option disabled selected value="">Selecciona la situación</option>
                                <option value="ocupado">Ocupado</option>
                                <option value="dsp">Desempleado (DSP)</option>
                                <option value="dspld">Desempleado de larga duración (*) (DSPLD)</option>
                                <option value="cpn">Cuidador no profesional (CPN)</option>
                            </select>
                            <div id="participantStatusNote" class="alert alert-info d-none">
                                <p>
                                    <strong>(*)</strong> Personas inscritas como demandantes en la oficina de
                                    empleo al menos 12 meses en los 18 meses anteriores a la selección.
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div id="businessData" class="container-fluid d-none">
        <div class="row">
            <div
                class="col-xl-8 offset-xl-2 col-lg-10 offset-lg-1 col-12 offset-0 px-lg-5 px-3 py-4 mb-4 rounded alert alert-dark">
                <h1 class="text-center">Datos Empresariales</h1>
                <p class="text-center mb-5">(Solo para personas ocupadas)</p>
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-lg-6 col-12 mb-4">
                            <label for="company" class="form-label">Razón social de la empresa donde trabaja
                                actualmente*</label>
                            <input id="company" type="text" name="company" class="form-control">
                        </div>
                        <div class="col-lg-6 col-12 mb-4">
                            <label for="cif" class="form-label">CIF de la empresa donde trabaja actualmente*</label>
                            <input id="cif" type="text" name="cif" class="form-control">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-6 col-12 mb-4">
                            <label for="employmentRegime" class="form-label">Régimen de empleo*</label>
                            <select id="employmentRegime" name="employmentRegime" class="form-control" required>
                                <option disabled selected value="">Selecciona un régimen de empleo</option>
                                <option value="RG">RG - Régimen general</option>
                                <option value="FD">FD - Fijos discontinuos en periodos de no ocupación</option>
                                <option value="RE">RE - Regulación de empleo en períodos de no ocupación</option>
                                <option value="ERTE">ERTE - Personas trabajadoras afectadas por expedientes de
                                    regulación temporal de empleo
                                </option>
                                <option value="RERED">RERED - Trabajadores en ERTE afectados por Mecanismo RED</option>
                                <option value="AGP">AGP - Régimen especial agrario por cuenta propia</option>
                                <option value="AGA">AGA - Régimen especial agrario por cuenta ajena</option>
                                <option value="AU">AU - Régimen especial autónomos</option>
                                <option value="AP">AP - Administración Pública</option>
                                <option value="EH">EH - Empleado hogar</option>
                                <option value="DF">DF - Trabajadores que accedan al desempleo durante el periodo
                                    formativo
                                </option>
                                <option value="RLE">RLE - Trabajadores con relaciones laborales especiales según art. 2
                                    del Estatuto
                                </option>
                                <option value="CESS">CESS - Trabajadores con convenio especial con la Seguridad Social
                                </option>
                                <option value="FDI">FDI - Trabajadores a tiempo parcial indefinido con trabajos
                                    discontinuos
                                </option>
                                <option value="TM">TM - Régimen especial del mar</option>
                                <option value="CP">CP - Mutualistas de Colegios Profesionales no incluidos como
                                    autónomos
                                </option>
                                <option value="OCTP">OCTP - Trabajadores ocupados con contrato a tiempo parcial</option>
                                <option value="OCT">OCT - Trabajadores ocupados con contrato temporal</option>
                            </select>
                        </div>
                        <div class="col-lg-6 col-12 mb-4">
                            <label for="functionalArea" class="form-label">Cargo* (Área funcional)</label>
                            <select id="functionalArea" name="functionalArea" class="form-control" required>
                                <option disabled selected value="">Selecciona un área funcional</option>
                                <option value="direccion">Dirección</option>
                                <option value="administracion">Administración</option>
                                <option value="comercial">Comercial</option>
                                <option value="mantenimiento">Mantenimiento</option>
                                <option value="produccion">Producción</option>
                            </select>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="container-fluid">
        <div class="row">
            <div class="col-xl-8 offset-xl-2 col-lg-10 offset-lg-1 col-12 offset-0 px-lg-5 px-1 py-4 mb-4 rounded alert alert-info">
                <h2 class="text-center mb-3">Firme aquí</h2>
                <canvas id="signatureCanvas" class="w-100 bg-white rounded border border-black border-2 mb-2"></canvas>
                <div class="text-center">
                    <button id="clearCanvas" type="button" class="btn btn-danger px-3 py-1"><strong>Borrar</strong></button>
                </div>
                <input id="signatureInput" type="hidden" name="signature">
            </div>
        </div>
    </div>
    <div class="text-center">
        <button id="submitBtn" type="submit" class="btn btn-secondary px-5 py-2"><strong>Enviar</strong></button>
    </div>
</form>
<script type="text/javascript" src="{{asset('js/choices.min.js')}}"></script>
<script type="text/javascript" src="{{asset('js/justValidate.min.js')}}"></script>
<script type="text/javascript" src="{{asset('js/main.js?v=4')}}"></script>
</body>
</html>
