<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Arcade Portal - JOUE TON OST</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Press+Start+2P&family=Rajdhani:wght@700&family=Russo+One&display=swap" rel="stylesheet">
    <style>
        iframe {
            /* On définit une taille virtuelle double (200%) */
            width: 1%;
            height: 1%;

            border: none;
            pointer-events: none;
            background: #0f172a;
        }
        body {
            margin: 0;
            background-color: #020617;
            height: 100vh;
            width: 100vw;
            overflow: hidden;
            display: flex;
            justify-content: center;
            align-items: center;
            font-family: 'Rajdhani', sans-serif;
        }

        /* --- WRAPPER PRINCIPAL --- */
        #arcade-wrapper {
            position: relative;
            /* Dimensions basées sur le ratio de votre dessin (environ 500x700) */
            width: min(90vw, 600px);
            aspect-ratio: 1 / 1;

            /* Zoom centré sur l'écran */
            transform-origin: 50% 42%; /* MODIFIÉ */
            transition: transform 1.2s cubic-bezier(0.65, 0, 0.35, 1);
            will-change: transform;
        }

        /* --- DESSIN SVG --- */
        #arcade-svg {
            width: 100%;
            height: 100%;
            display: block;
            filter: drop-shadow(0 0 30px rgba(192, 38, 211, 0.15));
            /* Les éléments pointer-events:none permettent de cliquer à travers si besoin */
        }

        /* --- L'ÉCRAN (IFRAME) --- */
        #screen-container {
            /* ...conservez vos styles actuels (top, left, width, height)... */
            position: absolute;
            top: 25.7%;
            left: 28.1%;
            width: 44.2%;
            height: 32.1%;
            background: #000;
            z-index: -1;
            border-radius: 2% / 3%;
            overflow: hidden; /* TRÈS IMPORTANT: ajoutez cette ligne */
        }

        /* Le nouveau wrapper qui sera mis à l'échelle */
        #iframe-viewport {
            /* On définit la "vraie" taille du site que l'on veut afficher */
            /* Un ratio 16:9 est standard pour un affichage desktop */
            width: 1920px;
            height: 1080px;

            /* On calcule le facteur de scale pour la largeur */
            /* La largeur de l'écran est de 44.2% de son parent.
               On utilise une variable pour plus de clarté.
               --scale: calc((44.2vw) / 1920px)
               Cela donne un chiffre très petit, on va devoir ajuster dynamiquement.
               La meilleure approche est d'utiliser une échelle fixe et ajuster la taille virtuelle.
            */
            width: 1280px; /* Taille virtuelle de l'écran desktop */
            height: 720px; /* Ratio 16:9 */

            /* On réduit le tout pour que 1280px rentrent dans la petite fenêtre */
            transform: scale(0.21); /* Essai/erreur: 265px (largeur réelle) / 1280px (largeur virtuelle) ≈ 0.207 */
            transform-origin: 0 0; /* On ancre la transformation en haut à gauche */
        }

        /* L'iframe prend 100% de son parent (le viewport de 1280x720) */
        #iframe-viewport iframe {
            width: 100%;
            height: 100%;
            border: none;
            background: #0f172a;
            pointer-events: none; /* Gardez ceci si l'interaction n'est pas voulue */
        }

        iframe {
            width: 100%; height: 100%; border: none;
            pointer-events: none; background: #0f172a;
        }

        /* --- OVERLAYS CRT --- */
        .overlay-effects {
            position: absolute; inset: 0; z-index: 20;
            pointer-events: none; transition: opacity 0.5s;
        }
        .scanlines {
            background: repeating-linear-gradient(to bottom, transparent 0%, transparent 2px, rgba(0,0,0,0.15) 3px);
            background-size: 100% 4px;
        }
        .glare {
            background: linear-gradient(135deg, rgba(255,255,255,0.1) 0%, transparent 60%);
        }

        /* Trigger Click */
        #click-trigger {
            position: absolute; inset: 0; z-index: 30; cursor: pointer;
        }

        /* --- ANIMATION --- */
        body.launching #arcade-wrapper {
            transform: scale(4.5);
        }
        body.launching #arcade-svg,
        body.launching .overlay-effects,
        body.launching #ui-hint {
            opacity: 0;
            transition: opacity 0.3s;
        }

        @media (max-width: 600px) {
            body.launching #arcade-wrapper { transform: scale(6.5); }
        }
    </style>
</head>
<body>

<div id="arcade-wrapper">

    <!-- DESSIN VECTORIEL RECRÉÉ D'APRÈS VOTRE IMAGE -->
    <svg id="arcade-svg" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 500 500">
        <defs>
            <style>
                .cls-1 {
                    fill: #96155d;
                }

                .cls-1, .cls-2, .cls-3, .cls-4, .cls-5, .cls-6, .cls-7, .cls-8, .cls-9, .cls-10, .cls-11, .cls-12, .cls-13, .cls-14, .cls-15, .cls-16, .cls-17, .cls-18, .cls-19, .cls-20, .cls-21 {
                    fill-rule: evenodd;
                }

                .cls-2 {
                    fill: #ffe601;
                }

                .cls-22 {
                    fill: #f6f6f6;
                }

                .cls-23 {
                    mask: url(#mask-1);
                }

                .cls-3 {
                    fill: #262a2f;
                }

                .cls-4, .cls-24 {
                    fill: #522247;
                }

                .cls-5 {
                    fill: #458c7e;
                }

                .cls-25, .cls-26, .cls-8 {
                    fill: #fff;
                }

                .cls-26 {
                    font-family: Orbitron-ExtraBold, Orbitron;
                    font-size: 14.89px;
                    font-variation-settings: 'wght' 800;
                    font-weight: 700;
                    letter-spacing: .07em;
                }

                .cls-27 {
                    mask: url(#mask);
                }

                .cls-6 {
                    fill: #335aa6;
                }

                .cls-7 {
                    fill: #76154f;
                }

                .cls-9, .cls-28 {
                    fill: #dadada;
                }

                .cls-29 {
                    opacity: .5;
                }

                .cls-29, .cls-30 {
                    mix-blend-mode: overlay;
                }

                .cls-31 {
                    isolation: isolate;
                }

                .cls-32, .cls-15 {
                    fill: #c10a6e;
                }

                .cls-28 {
                    mix-blend-mode: multiply;
                }

                .cls-10 {
                    fill: url(#Dégradé_sans_nom_186);
                    z-index: 100;
                }

                .cls-11 {
                    fill: #c9c9ca;
                }

                .cls-12 {
                    fill: #eeb228;
                }

                .cls-13 {
                    fill: url(#Dégradé_sans_nom_179);
                    z-index: 100;
                }

                .cls-14 {
                    fill: url(#Dégradé_sans_nom_89);
                }

                .cls-33 {
                    fill: #ededed;
                }

                .cls-16 {
                    fill: #b2b2b2;
                }

                .cls-34 {
                    fill: url(#Dégradé_sans_nom_27);
                }

                .cls-35 {
                    fill: url(#Dégradé_sans_nom_208);
                }

                .cls-17 {
                    fill: #1b3c6f;
                }

                .cls-18 {
                    fill: #8e1558;
                }

                .cls-36 {
                    fill: url(#Dégradé_sans_nom_198);
                }

                .cls-37 {
                    filter: url(#luminosity-invert-2);
                }

                .cls-38 {
                    fill: url(#Dégradé_sans_nom_102);
                }

                .cls-30 {
                    opacity: .3;
                }

                .cls-19 {
                    fill: #3b1531;
                }

                .cls-39 {
                    filter: url(#luminosity-invert);
                }

                .cls-20 {
                    fill: #b6b6b7;
                }

                .cls-21 {
                    fill: #66c0b3;
                }

                .cls-40 {
                    fill: url(#Dégradé_sans_nom_33);
                }
            </style>
            <linearGradient id="Dégradé_sans_nom_208" data-name="Dégradé sans nom 208" x1="251.2" y1="320.71" x2="251.2" y2="377.7" gradientUnits="userSpaceOnUse">
                <stop offset="0" stop-color="#662483"/>
                <stop offset=".18" stop-color="#6e2181"/>
                <stop offset=".47" stop-color="#851a7b"/>
                <stop offset=".82" stop-color="#ab1073"/>
                <stop offset="1" stop-color="#c10a6e"/>
            </linearGradient>
            <linearGradient id="Dégradé_sans_nom_89" data-name="Dégradé sans nom 89" x1="251.22" y1="172.8" x2="251.22" y2="93.78" gradientUnits="userSpaceOnUse">
                <stop offset="0" stop-color="#361d49"/>
                <stop offset=".16" stop-color="#3e1c4c"/>
                <stop offset=".42" stop-color="#551b54"/>
                <stop offset=".73" stop-color="#7b1961"/>
                <stop offset="1" stop-color="#a0186f"/>
            </linearGradient>
            <radialGradient id="Dégradé_sans_nom_179" data-name="Dégradé sans nom 179" cx="160.59" cy="285.12" fx="160.59" fy="285.12" r="27.21" gradientUnits="userSpaceOnUse">
                <stop offset="0" stop-color="#6785c3"/>
                <stop offset=".5" stop-color="#335aa6"/>
                <stop offset="1" stop-color="#264170"/>
            </radialGradient>
            <radialGradient id="Dégradé_sans_nom_186" data-name="Dégradé sans nom 186" cx="281.75" cy="287.4" fx="281.75" fy="287.4" r="24.69" gradientUnits="userSpaceOnUse">
                <stop offset="0" stop-color="#6785c3"/>
                <stop offset=".5" stop-color="#335aa6"/>
                <stop offset="1" stop-color="#264170"/>
            </radialGradient>
            <linearGradient id="Dégradé_sans_nom_102" data-name="Dégradé sans nom 102" x1="251.51" y1="48.85" x2="251.51" y2="71.29" gradientTransform="translate(0 .46)" gradientUnits="userSpaceOnUse">
                <stop offset="0" stop-color="#1c2647"/>
                <stop offset=".11" stop-color="#fff"/>
                <stop offset=".4" stop-color="#1c2647"/>
                <stop offset=".6" stop-color="#fff"/>
                <stop offset=".8" stop-color="#1c2647"/>
                <stop offset="1" stop-color="#081f2c"/>
            </linearGradient>
            <linearGradient id="Dégradé_sans_nom_33" data-name="Dégradé sans nom 33" x1="251.51" y1="48.85" x2="251.51" y2="71.29" gradientUnits="userSpaceOnUse">
                <stop offset="0" stop-color="#1c2647"/>
                <stop offset=".2" stop-color="#fff"/>
                <stop offset=".4" stop-color="#1c2647"/>
                <stop offset=".6" stop-color="#fff"/>
                <stop offset=".8" stop-color="#1c2647"/>
                <stop offset="1" stop-color="#081f2c"/>
            </linearGradient>
            <linearGradient id="Dégradé_sans_nom_27" data-name="Dégradé sans nom 27" x1="251.51" y1="49.76" x2="251.51" y2="70.38" gradientTransform="translate(0 -.46)" gradientUnits="userSpaceOnUse">
                <stop offset="0" stop-color="#1c2647"/>
                <stop offset=".2" stop-color="#fff"/>
                <stop offset=".4" stop-color="#1c2647"/>
                <stop offset=".6" stop-color="#fff"/>
                <stop offset=".8" stop-color="#1c2647"/>
                <stop offset="1" stop-color="#081f2c"/>
            </linearGradient>
            <linearGradient id="Dégradé_sans_nom_198" data-name="Dégradé sans nom 198" x1="251.51" y1="49.76" x2="251.51" y2="70.38" gradientTransform="translate(.23)" gradientUnits="userSpaceOnUse">
                <stop offset="0" stop-color="#010101"/>
                <stop offset=".26" stop-color="#335aa6"/>
                <stop offset=".45" stop-color="#bfd0ec"/>
                <stop offset=".64" stop-color="#1e1e1c"/>
                <stop offset=".82" stop-color="#c10a6e"/>
                <stop offset="1" stop-color="#fff"/>
            </linearGradient>
            <filter id="luminosity-invert" x="176" y="47" width="152" height="26" color-interpolation-filters="sRGB" filterUnits="userSpaceOnUse">
                <feColorMatrix result="cm" values="-1 0 0 0 1 0 -1 0 0 1 0 0 -1 0 1 0 0 0 1 0"/>
            </filter>
            <mask id="mask" x="176" y="47" width="152" height="26" maskUnits="userSpaceOnUse">
                <g class="cls-39">
                    <use transform="translate(176 47)" xlink:href="#image"/>
                </g>
            </mask>
            <filter id="luminosity-invert-2" x="176" y="47" width="152" height="26" color-interpolation-filters="sRGB" filterUnits="userSpaceOnUse">
                <feColorMatrix result="cm" values="-1 0 0 0 1 0 -1 0 0 1 0 0 -1 0 1 0 0 0 1 0"/>
            </filter>
            <mask id="mask-1" x="176" y="47" width="152" height="26" maskUnits="userSpaceOnUse">
                <g class="cls-37">
                    <use transform="translate(176 47)" xlink:href="#image"/>
                </g>
            </mask>
        </defs>
        <g class="cls-31">
            <g id="OBJECTS">
                <rect class="cls-24" x="129.7" y="379.36" width="243" height="120.49"/>
                <rect class="cls-28" x="129.7" y="379.36" width="243" height="53.31"/>
                <polygon class="cls-20" points="114.22 30.47 120.04 24.04 131.48 36.69 116.18 37.31 114.22 30.47"/>
                <polygon class="cls-20" points="388.21 30.47 382.37 24.04 370.93 36.69 386.25 37.31 388.21 30.47"/>
                <polygon class="cls-11" points="110.87 400.06 120.04 405.53 129.7 397.86 121.16 389.81 110.87 400.06"/>
                <polygon class="cls-11" points="391.54 400.06 382.37 405.53 372.7 397.86 381.28 389.81 391.54 400.06"/>
                <rect class="cls-32" x="120.04" y="36.16" width="262.33" height="42.99"/>
                <path class="cls-19" d="M140.61,128.69v160.66h221.21v-160.66h-221.21ZM329.84,267.53c-52.41,2.37-104.83,2.37-157.25,0-1.67-.07-3.19-.77-4.34-1.85l.06-.06c-3-36.25-2.99-73.27-.16-110.98,1.05-2.35,3.3-3.99,5.95-4.1,51.42-2.32,102.83-2.32,154.24,0,2.68.12,4.97,1.82,5.98,4.23,3.37,37.76,3.41,74.74-.2,110.86l.06.06c-1.15,1.09-2.68,1.78-4.35,1.85Z"/>
                <polygon class="cls-4" points="120.04 344.3 382.37 344.3 361.82 289.35 140.61 289.35 120.04 344.3"/>
                <rect class="cls-35" x="120.04" y="344.3" width="262.33" height="53.55"/>
                <rect class="cls-22" x="104.4" y="24.04" width="15.63" height="55.11"/>
                <polygon class="cls-11" points="104.4 79.15 120.04 79.15 140.4 128.69 124.76 128.69 104.4 79.15"/>
                <rect class="cls-33" x="124.76" y="128.69" width="15.63" height="160.66"/>
                <polygon class="cls-9" points="140.4 289.35 124.76 289.35 104.4 344.3 120.04 344.3 140.4 289.35"/>
                <rect class="cls-22" x="104.4" y="344.3" width="15.63" height="61.23"/>
                <rect class="cls-22" x="382.37" y="24.04" width="15.63" height="55.11"/>
                <polygon class="cls-11" points="398 79.15 382.37 79.15 362.01 128.69 377.64 128.69 398 79.15"/>
                <rect class="cls-33" x="362.01" y="128.69" width="15.63" height="160.66"/>
                <polygon class="cls-9" points="362.01 289.35 377.64 289.35 398 344.3 382.37 344.3 362.01 289.35"/>
                <rect class="cls-22" x="382.37" y="344.3" width="15.63" height="61.23"/>
                <path class="cls-7" d="M159.92,144.05v129.96h182.57v-129.96h-182.57ZM329.84,267.53c-52.41,2.37-104.83,2.37-157.25,0-1.67-.07-3.19-.77-4.34-1.85l.06-.06c-3-36.25-2.99-73.27-.16-110.98,1.05-2.35,3.3-3.99,5.95-4.1,51.42-2.32,102.83-2.32,154.24,0,2.68.12,4.97,1.82,5.98,4.23,3.37,37.76,3.41,74.74-.2,110.86l.06.06c-1.15,1.09-2.68,1.78-4.35,1.85Z"/>
                <path class="cls-1" d="M168.31,265.61l-8.39,8.39v-129.96l8.39,8.39c-.06.73-.11,1.46-.16,2.19-2.83,37.71-2.84,74.73.16,110.98Z"/>
                <path class="cls-1" d="M342.49,144.05v129.96l-8.31-8.33-.06-.06c3.61-36.12,3.57-73.1.2-110.86-.06-.77-.12-1.55-.2-2.31l8.37-8.39Z"/>
                <polygon class="cls-16" points="140.4 128.69 140.4 289.35 120.04 344.3 120.04 390.89 120.04 397.86 120.04 405.53 123.61 402.71 129.7 397.86 123.64 397.86 123.67 392.17 123.89 344.3 144.62 289.35 144.31 128.69 123.52 79.15 123.27 27.58 123.3 36.16 131.01 36.16 123.27 27.58 120.04 24.04 120.04 79.15 140.4 128.69"/>
                <polygon class="cls-16" points="362.01 128.69 362.01 289.35 382.37 344.3 382.37 390.89 382.37 397.86 382.37 405.53 378.82 402.71 372.7 397.86 378.79 397.86 378.76 392.17 378.51 344.3 357.81 289.35 358.12 128.69 378.92 79.15 379.16 27.58 371.39 36.16 379.13 36.16 379.16 27.58 382.37 24.04 382.37 79.15 362.01 128.69"/>
                <polygon class="cls-14" points="123.52 79.15 144.31 128.69 358.12 128.69 378.92 79.15 123.52 79.15"/>
                <path class="cls-8" d="M224.21,320.4c4.84,0,8.77-2.02,8.77-4.48s-3.93-4.45-8.77-4.45-8.79,1.99-8.79,4.45,3.95,4.48,8.79,4.48h0Z"/>
                <path class="cls-8" d="M224.21,320.9c4.84,0,8.77-1.99,8.77-4.45s-3.93-4.45-8.77-4.45-8.79,1.99-8.79,4.45,3.95,4.45,8.79,4.45h0Z"/>
                <path class="cls-5" d="M224.26,311.5c3.06,0,5.65.03,6.2,1.57.08.21.05,1.52.05,1.73,0,1.83-2.8,3.32-6.26,3.32s-6.26-1.47-6.26-3.32c0-.16-.05-1.47,0-1.62.42-1.62,3.11-1.68,6.26-1.68h0Z"/>
                <path class="cls-21" d="M224.24,310.06c3.46,0,6.26,1.49,6.26,3.32s-2.8,3.3-6.26,3.3-6.26-1.47-6.26-3.3,2.8-3.32,6.26-3.32h0Z"/>
                <path class="cls-8" d="M194.89,320.9c4.84,0,8.79-1.99,8.79-4.45s-3.95-4.45-8.79-4.45-8.79,1.99-8.79,4.45,3.95,4.45,8.79,4.45h0Z"/>
                <path class="cls-18" d="M194.97,312.02c3.04,0,5.65.03,6.18,1.57.08.18.08,1.52.08,1.73,0,1.83-2.8,3.32-6.26,3.32s-6.26-1.47-6.26-3.32c0-.16-.05-1.47-.03-1.62.42-1.62,3.11-1.68,6.28-1.68h0Z"/>
                <path class="cls-15" d="M194.95,310.58c3.46,0,6.26,1.49,6.26,3.32s-2.8,3.3-6.26,3.3-6.26-1.47-6.26-3.3,2.8-3.32,6.26-3.32h0Z"/>
                <path class="cls-8" d="M209.84,311.53c4.84,0,8.77-2.02,8.77-4.48s-3.93-4.45-8.77-4.45-8.79,1.99-8.79,4.45,3.95,4.48,8.79,4.48h0Z"/>
                <path class="cls-12" d="M209.89,302.63c3.06,0,5.65.03,6.2,1.57.08.21.05,1.52.05,1.73,0,1.83-2.8,3.32-6.26,3.32s-6.26-1.47-6.26-3.32c0-.16-.05-1.47,0-1.62.42-1.62,3.11-1.68,6.26-1.68h0Z"/>
                <path class="cls-2" d="M209.87,301.19c3.46,0,6.26,1.49,6.26,3.32s-2.8,3.3-6.26,3.3-6.26-1.47-6.26-3.3,2.8-3.32,6.26-3.32h0Z"/>
                <path class="cls-8" d="M209.66,330.66c4.84,0,8.79-2.02,8.79-4.48s-3.95-4.45-8.79-4.45-8.79,1.99-8.79,4.45,3.95,4.48,8.79,4.48h0Z"/>
                <path class="cls-17" d="M209.73,321.76c3.04,0,5.65.03,6.18,1.57.08.18.05,1.52.05,1.73,0,1.83-2.8,3.32-6.23,3.32s-6.26-1.47-6.26-3.32c0-.16-.05-1.47-.03-1.62.42-1.62,3.11-1.68,6.28-1.68h0Z"/>
                <path class="cls-6" d="M209.71,320.32c3.46,0,6.26,1.49,6.26,3.32s-2.8,3.3-6.26,3.3-6.26-1.47-6.26-3.3,2.8-3.32,6.26-3.32h0Z"/>
                <path class="cls-8" d="M164.06,324.9c8.93,0,16.2-3.69,16.2-8.22s-7.28-8.25-16.2-8.25-16.23,3.72-16.23,8.25,7.28,8.22,16.23,8.22h0Z"/>
                <path class="cls-3" d="M164.06,321.63c7.12,0,12.96-2.67,12.96-5.99s-5.84-5.99-12.96-5.99-12.98,2.7-12.98,5.99,5.84,5.99,12.98,5.99h0Z"/>
                <path class="cls-20" d="M164.53,301.08h0c1.57,0,2.83,1.28,2.83,2.83v10.13c0,2.12-5.71,2.04-5.71-.16l.05-9.97c0-1.54,1.26-2.83,2.83-2.83h0Z"/>
                <path class="cls-13" d="M164.45,305.64c6.07,0,11.02-4.79,11.02-10.65s-4.95-10.65-11.02-10.65-11.02,4.79-11.02,10.65,4.95,10.65,11.02,10.65h0Z"/>
                <path class="cls-8" d="M345.8,320.4c4.84,0,8.77-2.02,8.77-4.48s-3.93-4.45-8.77-4.45-8.79,1.99-8.79,4.45,3.95,4.48,8.79,4.48h0Z"/>
                <path class="cls-8" d="M345.8,320.9c4.84,0,8.77-1.99,8.77-4.45s-3.93-4.45-8.77-4.45-8.79,1.99-8.79,4.45,3.95,4.45,8.79,4.45h0Z"/>
                <path class="cls-5" d="M345.86,311.5c3.06,0,5.65.03,6.2,1.57.08.21.05,1.52.05,1.73,0,1.83-2.8,3.32-6.26,3.32s-6.26-1.47-6.26-3.32c0-.16-.05-1.47,0-1.62.42-1.62,3.11-1.68,6.26-1.68h0Z"/>
                <path class="cls-21" d="M345.83,310.06c3.46,0,6.26,1.49,6.26,3.32s-2.8,3.3-6.26,3.3-6.26-1.47-6.26-3.3,2.8-3.32,6.26-3.32h0Z"/>
                <path class="cls-8" d="M316.49,320.9c4.84,0,8.79-1.99,8.79-4.45s-3.95-4.45-8.79-4.45-8.79,1.99-8.79,4.45,3.95,4.45,8.79,4.45h0Z"/>
                <path class="cls-18" d="M316.57,312.02c3.04,0,5.65.03,6.18,1.57.08.18.08,1.52.08,1.73,0,1.83-2.8,3.32-6.26,3.32s-6.26-1.47-6.26-3.32c0-.16-.05-1.47-.03-1.62.42-1.62,3.11-1.68,6.28-1.68h0Z"/>
                <path class="cls-15" d="M316.54,310.58c3.46,0,6.26,1.49,6.26,3.32s-2.8,3.3-6.26,3.3-6.26-1.47-6.26-3.3,2.8-3.32,6.26-3.32h0Z"/>
                <path class="cls-8" d="M331.43,311.53c4.84,0,8.77-2.02,8.77-4.48s-3.93-4.45-8.77-4.45-8.79,1.99-8.79,4.45,3.95,4.48,8.79,4.48h0Z"/>
                <path class="cls-12" d="M331.49,302.63c3.06,0,5.65.03,6.2,1.57.08.21.05,1.52.05,1.73,0,1.83-2.8,3.32-6.26,3.32s-6.26-1.47-6.26-3.32c0-.16-.05-1.47,0-1.62.42-1.62,3.11-1.68,6.26-1.68h0Z"/>
                <path class="cls-2" d="M331.46,301.19c3.46,0,6.26,1.49,6.26,3.32s-2.8,3.3-6.26,3.3-6.26-1.47-6.26-3.3,2.8-3.32,6.26-3.32h0Z"/>
                <path class="cls-8" d="M331.25,330.66c4.84,0,8.79-2.02,8.79-4.48s-3.95-4.45-8.79-4.45-8.79,1.99-8.79,4.45,3.95,4.48,8.79,4.48h0Z"/>
                <path class="cls-17" d="M331.33,321.76c3.04,0,5.65.03,6.18,1.57.08.18.05,1.52.05,1.73,0,1.83-2.8,3.32-6.23,3.32s-6.26-1.47-6.26-3.32c0-.16-.05-1.47-.03-1.62.42-1.62,3.11-1.68,6.28-1.68h0Z"/>
                <path class="cls-6" d="M331.3,320.32c3.46,0,6.26,1.49,6.26,3.32s-2.8,3.3-6.26,3.3-6.26-1.47-6.26-3.3,2.8-3.32,6.26-3.32h0Z"/>
                <path class="cls-8" d="M285.65,324.9c8.93,0,16.2-3.69,16.2-8.22s-7.28-8.25-16.2-8.25-16.23,3.72-16.23,8.25,7.28,8.22,16.23,8.22h0Z"/>
                <path class="cls-3" d="M285.65,321.63c7.12,0,12.96-2.67,12.96-5.99s-5.84-5.99-12.96-5.99-12.98,2.7-12.98,5.99,5.84,5.99,12.98,5.99h0Z"/>
                <path class="cls-20" d="M286.13,301.08h0c1.57,0,2.83,1.28,2.83,2.83v10.13c0,2.12-5.71,2.04-5.71-.16l.05-9.97c0-1.54,1.26-2.83,2.83-2.83h0Z"/>
                <path class="cls-10" d="M286.05,305.64c6.07,0,11.02-4.79,11.02-10.65s-4.95-10.65-11.02-10.65-11.02,4.79-11.02,10.65,4.95,10.65,11.02,10.65h0Z"/>
                <g>
                    <g>
                        <path class="cls-38" d="M183.71,71.75c-1.22,0-2.35-.21-3.38-.62s-1.86-.98-2.47-1.68c-.61-.71-.92-1.47-.92-2.31v-13.21c0-.85.3-1.63.92-2.32.61-.7,1.43-1.25,2.47-1.67s2.16-.62,3.38-.62h19.35c1.25,0,2.39.21,3.41.62,1.02.42,1.84.97,2.47,1.67.62.7.94,1.47.94,2.32v2.12h-7.18v-1.87h-18.66v12.71h18.66v-3.37h-7.13v-4.86h14.31v8.48c0,.83-.31,1.6-.94,2.31-.62.71-1.45,1.27-2.47,1.68-1.02.42-2.16.62-3.41.62h-19.35Z"/>
                        <path class="cls-38" d="M215,53.92c0-.85.3-1.63.91-2.32.61-.7,1.43-1.25,2.47-1.67,1.04-.42,2.16-.62,3.38-.62h19.35c1.25,0,2.39.21,3.41.62,1.02.42,1.84.97,2.47,1.67.62.7.94,1.47.94,2.32v17.83h-7.18v-7.23h-18.66v7.23h-7.09v-17.83ZM240.74,59.66v-5.48h-18.66v5.48h18.66Z"/>
                        <path class="cls-38" d="M253.14,71.75v-22.44h7.32l11.16,9.07,11.11-9.07h7.36v22.44h-7.13v-15.05l-11.34,9.22-11.39-9.19v15.02h-7.09Z"/>
                        <path class="cls-38" d="M295.67,71.75v-22.44h30.41v4.86h-23.23v3.93h18.71v4.86h-18.71v3.93h23.23v4.86h-30.41Z"/>
                    </g>
                    <g>
                        <path class="cls-40" d="M183.71,71.29c-1.22,0-2.35-.21-3.38-.62s-1.86-.98-2.47-1.68c-.61-.71-.92-1.47-.92-2.31v-13.21c0-.85.3-1.63.92-2.32.61-.7,1.43-1.25,2.47-1.67s2.16-.62,3.38-.62h19.35c1.25,0,2.39.21,3.41.62,1.02.42,1.84.97,2.47,1.67.62.7.94,1.47.94,2.32v2.12h-7.18v-1.87h-18.66v12.71h18.66v-3.37h-7.13v-4.86h14.31v8.48c0,.83-.31,1.6-.94,2.31-.62.71-1.45,1.27-2.47,1.68-1.02.42-2.16.62-3.41.62h-19.35Z"/>
                        <path class="cls-40" d="M215,53.47c0-.85.3-1.63.91-2.32.61-.7,1.43-1.25,2.47-1.67,1.04-.42,2.16-.62,3.38-.62h19.35c1.25,0,2.39.21,3.41.62,1.02.42,1.84.97,2.47,1.67.62.7.94,1.47.94,2.32v17.83h-7.18v-7.23h-18.66v7.23h-7.09v-17.83ZM240.74,59.2v-5.48h-18.66v5.48h18.66Z"/>
                        <path class="cls-40" d="M253.14,71.29v-22.44h7.32l11.16,9.07,11.11-9.07h7.36v22.44h-7.13v-15.05l-11.34,9.22-11.39-9.19v15.02h-7.09Z"/>
                        <path class="cls-40" d="M295.67,71.29v-22.44h30.41v4.86h-23.23v3.93h18.71v4.86h-18.71v3.93h23.23v4.86h-30.41Z"/>
                    </g>
                    <g>
                        <path class="cls-34" d="M183.71,69.92c-1.1,0-2.12-.19-3.05-.56-.9-.36-1.61-.84-2.12-1.43-.47-.54-.69-1.1-.69-1.71v-13.21c0-.63.23-1.19.69-1.72.51-.58,1.23-1.06,2.12-1.42.92-.37,1.95-.56,3.05-.56h19.35c1.12,0,2.16.19,3.06.56.89.36,1.61.84,2.14,1.43.47.53.7,1.09.7,1.71v1.21h-5.36v-1.87h-20.48v14.54h20.48v-5.19h-7.13v-3.04h12.49v7.56c0,.61-.23,1.16-.71,1.7-.53.6-1.25,1.08-2.13,1.44-.91.37-1.94.56-3.06.56h-19.35Z"/>
                        <path class="cls-34" d="M241.65,69.92v-7.23h-20.48v7.23h-5.27v-16.91c0-.63.23-1.19.69-1.72.51-.58,1.23-1.06,2.12-1.42.92-.37,1.95-.56,3.05-.56h19.35c1.13,0,2.16.19,3.06.56.89.36,1.61.84,2.13,1.43.47.53.7,1.09.7,1.71v16.91h-5.36ZM221.17,59.66h20.48v-7.31h-20.48v7.31Z"/>
                        <polygon class="cls-34" points="283.87 69.92 283.87 53.87 271.61 63.84 259.32 53.91 259.32 69.92 254.05 69.92 254.05 49.31 260.13 49.31 271.62 58.64 283.05 49.31 289.18 49.31 289.18 69.92 283.87 69.92"/>
                        <polygon class="cls-34" points="296.58 69.92 296.58 49.31 325.17 49.31 325.17 52.35 301.94 52.35 301.94 58.1 320.65 58.1 320.65 61.14 301.94 61.14 301.94 66.89 325.17 66.89 325.17 69.92 296.58 69.92"/>
                    </g>
                    <g>
                        <g>
                            <g>
                                <path class="cls-36" d="M183.94,70.38c-1.1,0-2.12-.19-3.05-.56-.9-.36-1.61-.84-2.12-1.43-.47-.54-.69-1.1-.69-1.71v-13.21c0-.63.23-1.19.69-1.72.51-.58,1.23-1.06,2.12-1.42.92-.37,1.95-.56,3.05-.56h19.35c1.12,0,2.16.19,3.06.56.89.36,1.61.84,2.14,1.43.47.53.7,1.09.7,1.71v1.21h-5.36v-1.87h-20.48v14.54h20.48v-5.19h-7.13v-3.04h12.49v7.56c0,.61-.23,1.16-.71,1.7-.53.6-1.25,1.08-2.13,1.44-.91.37-1.94.56-3.06.56h-19.35Z"/>
                                <path class="cls-36" d="M241.88,70.38v-7.23h-20.48v7.23h-5.27v-16.91c0-.63.23-1.19.69-1.72.51-.58,1.23-1.06,2.12-1.42.92-.37,1.95-.56,3.05-.56h19.35c1.13,0,2.16.19,3.06.56.89.36,1.61.84,2.13,1.43.47.53.7,1.09.7,1.71v16.91h-5.36ZM221.4,60.11h20.48v-7.31h-20.48v7.31Z"/>
                                <polygon class="cls-36" points="284.1 70.38 284.1 54.32 271.84 64.29 259.54 54.36 259.54 70.38 254.28 70.38 254.28 49.76 260.36 49.76 271.84 59.1 283.28 49.76 289.41 49.76 289.41 70.38 284.1 70.38"/>
                                <polygon class="cls-36" points="296.81 70.38 296.81 49.76 325.4 49.76 325.4 52.8 302.17 52.8 302.17 58.55 320.87 58.55 320.87 61.59 302.17 61.59 302.17 67.34 325.4 67.34 325.4 70.38 296.81 70.38"/>
                            </g>
                            <g class="cls-27">
                                <g class="cls-29">
                                    <path class="cls-25" d="M183.94,70.38c-1.1,0-2.12-.19-3.05-.56-.9-.36-1.61-.84-2.12-1.43-.47-.54-.69-1.1-.69-1.71v-13.21c0-.63.23-1.19.69-1.72.51-.58,1.23-1.06,2.12-1.42.92-.37,1.95-.56,3.05-.56h19.35c1.12,0,2.16.19,3.06.56.89.36,1.61.84,2.14,1.43.47.53.7,1.09.7,1.71v1.21h-5.36v-1.87h-20.48v14.54h20.48v-5.19h-7.13v-3.04h12.49v7.56c0,.61-.23,1.16-.71,1.7-.53.6-1.25,1.08-2.13,1.44-.91.37-1.94.56-3.06.56h-19.35Z"/>
                                    <path class="cls-25" d="M241.88,70.38v-7.23h-20.48v7.23h-5.27v-16.91c0-.63.23-1.19.69-1.72.51-.58,1.23-1.06,2.12-1.42.92-.37,1.95-.56,3.05-.56h19.35c1.13,0,2.16.19,3.06.56.89.36,1.61.84,2.13,1.43.47.53.7,1.09.7,1.71v16.91h-5.36ZM221.4,60.11h20.48v-7.31h-20.48v7.31Z"/>
                                    <polygon class="cls-25" points="284.1 70.38 284.1 54.32 271.84 64.29 259.54 54.36 259.54 70.38 254.28 70.38 254.28 49.76 260.36 49.76 271.84 59.1 283.28 49.76 289.41 49.76 289.41 70.38 284.1 70.38"/>
                                    <polygon class="cls-25" points="296.81 70.38 296.81 49.76 325.4 49.76 325.4 52.8 302.17 52.8 302.17 58.55 320.87 58.55 320.87 61.59 302.17 61.59 302.17 67.34 325.4 67.34 325.4 70.38 296.81 70.38"/>
                                </g>
                            </g>
                        </g>
                        <g class="cls-30">
                            <g>
                                <path class="cls-25" d="M183.94,70.38c-1.1,0-2.12-.19-3.05-.56-.9-.36-1.61-.84-2.12-1.43-.47-.54-.69-1.1-.69-1.71v-13.21c0-.63.23-1.19.69-1.72.51-.58,1.23-1.06,2.12-1.42.92-.37,1.95-.56,3.05-.56h19.35c1.12,0,2.16.19,3.06.56.89.36,1.61.84,2.14,1.43.47.53.7,1.09.7,1.71v1.21h-5.36v-1.87h-20.48v14.54h20.48v-5.19h-7.13v-3.04h12.49v7.56c0,.61-.23,1.16-.71,1.7-.53.6-1.25,1.08-2.13,1.44-.91.37-1.94.56-3.06.56h-19.35Z"/>
                                <path class="cls-25" d="M241.88,70.38v-7.23h-20.48v7.23h-5.27v-16.91c0-.63.23-1.19.69-1.72.51-.58,1.23-1.06,2.12-1.42.92-.37,1.95-.56,3.05-.56h19.35c1.13,0,2.16.19,3.06.56.89.36,1.61.84,2.13,1.43.47.53.7,1.09.7,1.71v16.91h-5.36ZM221.4,60.11h20.48v-7.31h-20.48v7.31Z"/>
                                <polygon class="cls-25" points="284.1 70.38 284.1 54.32 271.84 64.29 259.54 54.36 259.54 70.38 254.28 70.38 254.28 49.76 260.36 49.76 271.84 59.1 283.28 49.76 289.41 49.76 289.41 70.38 284.1 70.38"/>
                                <polygon class="cls-25" points="296.81 70.38 296.81 49.76 325.4 49.76 325.4 52.8 302.17 52.8 302.17 58.55 320.87 58.55 320.87 61.59 302.17 61.59 302.17 67.34 325.4 67.34 325.4 70.38 296.81 70.38"/>
                            </g>
                            <g class="cls-23">
                                <g class="cls-29">
                                    <path class="cls-25" d="M183.94,70.38c-1.1,0-2.12-.19-3.05-.56-.9-.36-1.61-.84-2.12-1.43-.47-.54-.69-1.1-.69-1.71v-13.21c0-.63.23-1.19.69-1.72.51-.58,1.23-1.06,2.12-1.42.92-.37,1.95-.56,3.05-.56h19.35c1.12,0,2.16.19,3.06.56.89.36,1.61.84,2.14,1.43.47.53.7,1.09.7,1.71v1.21h-5.36v-1.87h-20.48v14.54h20.48v-5.19h-7.13v-3.04h12.49v7.56c0,.61-.23,1.16-.71,1.7-.53.6-1.25,1.08-2.13,1.44-.91.37-1.94.56-3.06.56h-19.35Z"/>
                                    <path class="cls-25" d="M241.88,70.38v-7.23h-20.48v7.23h-5.27v-16.91c0-.63.23-1.19.69-1.72.51-.58,1.23-1.06,2.12-1.42.92-.37,1.95-.56,3.05-.56h19.35c1.13,0,2.16.19,3.06.56.89.36,1.61.84,2.13,1.43.47.53.7,1.09.7,1.71v16.91h-5.36ZM221.4,60.11h20.48v-7.31h-20.48v7.31Z"/>
                                    <polygon class="cls-25" points="284.1 70.38 284.1 54.32 271.84 64.29 259.54 54.36 259.54 70.38 254.28 70.38 254.28 49.76 260.36 49.76 271.84 59.1 283.28 49.76 289.41 49.76 289.41 70.38 284.1 70.38"/>
                                    <polygon class="cls-25" points="296.81 70.38 296.81 49.76 325.4 49.76 325.4 52.8 302.17 52.8 302.17 58.55 320.87 58.55 320.87 61.59 302.17 61.59 302.17 67.34 325.4 67.34 325.4 70.38 296.81 70.38"/>
                                </g>
                            </g>
                        </g>
                    </g>
                </g>
                <text class="cls-26" transform="translate(174.91 376.49)"><tspan x="0" y="0">JOUE TON OST !</tspan></text>
            </g>
        </g>
    </svg>

    <div id="screen-container">
        <div class="overlay-effects scanlines"></div>
        <div class="overlay-effects glare"></div>
        <div id="click-trigger"></div>

        <!-- On ajoute un wrapper pour le viewport -->
        <div id="iframe-viewport">
            <iframe src="{{ route('home') }}" title="Preview" scrolling="no"></iframe>
        </div>
    </div>


    <div id="ui-hint" class="absolute bottom-[5%] w-full text-center pointer-events-none">
            <span class="inline-block bg-black/50 px-3 py-1 rounded text-white/80 font-['Press_Start_2P'] text-[10px] animate-pulse">
                INSERT COIN / CLICK
            </span>
    </div>

</div>

<script>
    let isRedirecting = false;
    function startJourney() {
        if (isRedirecting) return;
        isRedirecting = true;
        document.body.classList.add('launching');
        setTimeout(() => {
            // Rediriger vers l'accueil après l'animation
            window.location.href = "{{ route('home') }}";
        }, 1000);
    }

    // Démarrer automatiquement l'animation après un court délai
    setTimeout(() => {
        startJourney();
    }, 3000); // 3 secondes avant de démarrer l'animation

    window.addEventListener('keydown', (e) => {
        if (e.code === 'Space' || e.code === 'Enter') startJourney();
    });
    document.getElementById('arcade-svg').addEventListener('click', startJourney);
    document.getElementById('arcade-svg').addEventListener('touchstart', (e) => {
        e.preventDefault(); startJourney();
    }, {passive: false});
</script>
</body>
</html>
