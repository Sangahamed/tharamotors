@extends('layouts.app')

@section('title', 'THARA MOTORS - Accueil')

@section('content')

    <!-- FAQ SECTION -->
    <section id="faq" class="py-20 lg:py-28 bg-[#ebedf1] relative overflow-hidden">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <div class="grid lg:grid-cols-2 gap-8 lg:gap-8 items-stretch">
                <!-- Colonne image – même dimensions que la carte formulaire -->
                <div class="hidden lg:flex h-full">
                    <div class="tilt-wrap relative z-10 w-full h-full">
                        <div class="tilt-card rounded-2xl overflow-hidden p-6 sm:p-8 flex flex-col h-full" data-tilt data-tilt-max="15" data-tilt-speed="400" data-tilt-perspective="1000">
                            <div class="tilt-shadow"></div>
                            <div class="tilt-glare"></div>
                            <img src="{{ asset('images/devis.png') }}" alt="Voiture illustration"
                                 class="w-full flex-1 object-cover tilt-float" style="animation-delay:0.4s;">
                        </div>
                    </div>
                </div>

                <!-- Colonne formulaire -->
                <div class="bg-white rounded-xl p-6 sm:p-8">
                    <div class="bg-white border-b border-gray-100 px-6 pt-8 pb-4 sm:px-10">
                        <div class="flex items-center gap-3">
                            <div class="h-8 w-1.5 bg-orange-500 rounded-full"></div>
                            <h1 class="text-3xl sm:text-4xl font-extrabold tracking-tight text-gray-900">Demander un devis
                            </h1>
                        </div>
                        <p class="text-gray-500 mt-2 text-sm sm:text-base ml-2.5">Remplissez le formulaire ci-dessous pour
                            recevoir une offre personnalisée.</p>
                    </div>

                    <div class="px-6 py-6 sm:px-10 sm:py-8">
                        <form id="devisForm" novalidate>
                           
                            <div class="grid grid-cols-1 gap-6 sm:grid-cols-2">
                                <div>
                                    <label for="nom" class="block text-sm font-semibold text-gray-700 mb-1.5">
                                        Nom <span class="text-red-500 text-base align-middle">*</span>
                                    </label>
                                    <input type="text" id="nom" name="nom" required
                                        class="w-full px-4 py-2.5 border border-gray-300 rounded-xl bg-gray-50/50 focus:bg-white focus:ring-2 focus:ring-orange-400 focus:border-orange-400 transition-all duration-200 placeholder:text-gray-400"
                                        placeholder="Dupont">
                                </div>
                                <div>
                                    <label for="prenom" class="block text-sm font-semibold text-gray-700 mb-1.5">
                                        Prénom(s) <span class="text-red-500 text-base align-middle">*</span>
                                    </label>
                                    <input type="text" id="prenom" name="prenom" required
                                        class="w-full px-4 py-2.5 border border-gray-300 rounded-xl bg-gray-50/50 focus:bg-white focus:ring-2 focus:ring-orange-400 focus:border-orange-400 transition-all duration-200 placeholder:text-gray-400"
                                        placeholder="Jean">
                                </div>
                            </div>

                            
                            <div class="grid grid-cols-1 gap-6 sm:grid-cols-2 mt-6">
                                <div>
                                    <label for="telephone" class="block text-sm font-semibold text-gray-700 mb-1.5">
                                        Téléphone <span class="text-red-500 text-base align-middle">*</span>
                                    </label>
                                    <input type="tel" id="telephone" name="telephone" required
                                        class="w-full px-4 py-2.5 border border-gray-300 rounded-xl bg-gray-50/50 focus:bg-white focus:ring-2 focus:ring-orange-400 focus:border-orange-400 transition-all duration-200 placeholder:text-gray-400"
                                        placeholder="+225 0565355079">
                                </div>
                                <div>
                                    <label for="email" class="block text-sm font-semibold text-gray-700 mb-1.5">
                                        Adresse e-mail <span class="text-red-500 text-base align-middle">*</span>
                                    </label>
                                    <input type="email" id="email" name="email" required
                                        class="w-full px-4 py-2.5 border border-gray-300 rounded-xl bg-gray-50/50 focus:bg-white focus:ring-2 focus:ring-orange-400 focus:border-orange-400 transition-all duration-200 placeholder:text-gray-400"
                                        placeholder="bsanga@example.com">
                                </div>
                            </div>

                            <!-- Marque et Modèle (saisie libre) -->
                            <div class="grid grid-cols-1 gap-6 sm:grid-cols-2 mt-7">
                                <div>
                                    <label for="marque" class="block text-sm font-semibold text-gray-700 mb-1.5">
                                        Marque
                                    </label>
                                    <input type="text" id="marque" name="marque"
                                        class="w-full px-4 py-2.5 border border-gray-300 rounded-xl bg-gray-50/50 focus:bg-white focus:ring-2 focus:ring-orange-400 focus:border-orange-400 transition-all duration-200 placeholder:text-gray-400"
                                        placeholder="Ex: Toyota, BMW, ...">
                                </div>
                                <div>
                                    <label for="modele" class="block text-sm font-semibold text-gray-700 mb-1.5">
                                        Modèle
                                    </label>
                                    <input type="text" id="modele" name="modele"
                                        class="w-full px-4 py-2.5 border border-gray-300 rounded-xl bg-gray-50/50 focus:bg-white focus:ring-2 focus:ring-orange-400 focus:border-orange-400 transition-all duration-200 placeholder:text-gray-400"
                                        placeholder="Ex: Corolla, Série 3, ...">
                                </div>
                            </div>

                            <!-- Commentaire -->
                            <div class="mt-7">
                                <label for="commentaire"
                                    class="block text-sm font-semibold text-gray-700 mb-1.5">Commentaire</label>
                                <textarea id="commentaire" name="commentaire" rows="4"
                                    class="w-full px-4 py-2.5 border border-gray-300 rounded-xl bg-gray-50/50 focus:bg-white focus:ring-2 focus:ring-orange-400 focus:border-orange-400 transition-all duration-200 resize-y placeholder:text-gray-400"
                                    placeholder="Détails supplémentaires, informations sur le projet, ou toute question..."></textarea>
                            </div>

                            <!-- Bouton d'envoi -->
                            <div class="mt-8">
                                <button type="submit"
                                    class="w-full bg-orange-700 hover:bg-orange-800 active:bg-orange-900 text-white font-bold py-3.5 px-6 rounded-xl shadow-md hover:shadow-lg transition-all duration-200 transform hover:scale-[1.01] focus:outline-none focus:ring-4 focus:ring-orange-300 focus:ring-offset-1">
                                    Envoyer la demande
                                </button>
                            </div>

                            <!-- Mention de sécurité -->
                            <div
                                class="mt-5 flex items-start gap-2 text-xs sm:text-sm text-gray-500 bg-gray-50/80 p-3 rounded-xl border border-gray-100">
                                <svg xmlns="http://www.w3.org/2000/svg"
                                    class="h-4 w-4 sm:h-5 sm:w-5 text-orange-500 flex-shrink-0 mt-0.5" fill="none"
                                    viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                                <span>Veuillez remplir tous les champs obligatoires.<br>
                                    NB:Entrez un numéro de téléphone whatsapp valide.</span>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>

@endsection

@push('scripts')
    <script>
        /* ========== FONCTIONS NAVIGATION MOBILE ========== */
        function toggleMobileNav() {
            var nav = document.getElementById('mobile-nav');
            var menuIcon = document.getElementById('menu-icon');
            var closeIcon = document.getElementById('close-icon');
            nav.classList.toggle('hidden');
            menuIcon.classList.toggle('hidden');
            closeIcon.classList.toggle('hidden');
        }

        function closeMobileNav() {
            document.getElementById('mobile-nav').classList.add('hidden');
            document.getElementById('menu-icon').classList.remove('hidden');
            document.getElementById('close-icon').classList.add('hidden');
        }
        window.addEventListener('scroll', function() {
            var navbar = document.getElementById('navbar');
            if (window.scrollY > 80) {
                navbar.classList.add('bg-[#0f1117]/95', 'backdrop-blur-md', 'shadow-lg');
            } else {
                navbar.classList.remove('bg-[#0f1117]/95', 'backdrop-blur-md', 'shadow-lg');
            }
        });

        /* ========== SCROLL CARDS ========== */
        function scrollCards(direction) {
            var container = document.getElementById('cards-container');
            container.scrollBy({
                left: direction === 'left' ? -320 : 320,
                behavior: 'smooth'
            });
        }

        document.addEventListener('DOMContentLoaded', function() {
            const form = document.getElementById('devisForm');
            
            form.addEventListener('submit', function(e) {
                e.preventDefault();

                // Récupération des champs
                const nom = document.getElementById('nom').value.trim();
                const prenom = document.getElementById('prenom').value.trim();
                const telephone = document.getElementById('telephone').value.trim();
                const email = document.getElementById('email').value.trim();
                const marque = document.getElementById('marque').value.trim();
                const modele = document.getElementById('modele').value.trim();
                const commentaire = document.getElementById('commentaire').value.trim();

                // Validation simple
                if (!nom || !prenom || !telephone || !email) {
                    alert('Veuillez remplir tous les champs obligatoires (Nom, Prénom, Téléphone, E-mail).');
                    return;
                }

                // Validation email basique
                const emailPattern = /^[^\s@]+@([^\s@]+\.)+[^\s@]+$/;
                if (!emailPattern.test(email)) {
                    alert('Veuillez saisir une adresse e-mail valide.');
                    return;
                }

                // Construction d'une phrase naturelle pour WhatsApp
                let message = `Bonjour, je souhaite obtenir un devis. Voici mes coordonnées :%0A%0A`;
                message += ` ${encodeURIComponent(nom)}%0A`;
                message += ` ${encodeURIComponent(prenom)}%0A`;
                message += `Téléphone : ${encodeURIComponent(telephone)}%0A`;
                message += `E-mail : ${encodeURIComponent(email)}%0A%0A`;

                if (marque || modele) {
                    message += `Je suis intéressé(e) par `;
                    if (marque) message += `la marque ${encodeURIComponent(marque)} `;
                    if (modele) message += `modèle ${encodeURIComponent(modele)}. `;
                    message += `%0A%0A`;
                }

                if (commentaire) {
                    message += `Commentaire : ${encodeURIComponent(commentaire)}%0A%0A`;
                }

                message += `Merci de me faire parvenir votre meilleure offre.`;

                // Numéro WhatsApp du destinataire (format international sans +)
                const phoneNumber = '{{ config("services.whatsapp.number") }}';

                // Création du lien WhatsApp
                const whatsappUrl = `https://wa.me/${phoneNumber}?text=${message}`;

                // Redirection vers WhatsApp
                window.open(whatsappUrl, '_blank');
            });
        });
    </script>
@endpush