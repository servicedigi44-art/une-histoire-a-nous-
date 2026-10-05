<?php

namespace Database\Seeders;

use App\Models\Chapter;
use App\Models\Friend;
use App\Models\Memory;
use App\Models\PersonalMessage;
use App\Models\Setting;
use App\Models\TimeCapsule;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Jeu de données DE DÉMONSTRATION uniquement, clairement identifiable,
     * destiné à vérifier que le parcours fonctionne de bout en bout.
     * Les vrais souvenirs seront ajoutés depuis l'administration.
     */
    public function run(): void
    {
        // --- Réglages globaux -------------------------------------------------
        Setting::set('site_title', 'Une histoire à nous');
        Setting::set('story_start_year', 2008);
        Setting::set('capsule_next_rendezvous_year', 2036);

        // --- Comptes ------------------------------------------------------------
        $admin = User::updateOrCreate(
            ['email' => 'admin@histoire.test'],
            ['name' => 'Admin', 'password' => Hash::make('ChangeMoi!2026'), 'role' => 'admin']
        );

        // --- Amis (démo) ----------------------------------------------------------
        $friendsData = [
            ['name' => 'Démo Ami 1', 'nickname' => 'Le Rigolo', 'birth_year' => 1998, 'bio' => "Texte de démonstration : à remplacer par la vraie bio depuis l'administration."],
            ['name' => 'Démo Ami 2', 'nickname' => 'La Sage', 'birth_year' => 1999, 'bio' => 'Texte de démonstration.'],
            ['name' => 'Démo Ami 3', 'nickname' => 'Le Capitaine', 'birth_year' => 1998, 'bio' => 'Texte de démonstration.'],
        ];

        $friends = collect($friendsData)->map(function ($data, $i) {
            return Friend::updateOrCreate(
                ['name' => $data['name']],
                $data + ['sort_order' => $i, 'is_active' => true]
            );
        });

        // Compte visiteur lié au premier ami (démo d'invitation)
        User::updateOrCreate(
            ['email' => 'ami1@histoire.test'],
            [
                'name' => $friends[0]->name,
                'password' => Hash::make('ChangeMoi!2026'),
                'role' => 'visitor',
                'friend_id' => $friends[0]->id,
            ]
        );

        // --- Chapitres --------------------------------------------------------
        $chaptersData = [
            [1, 'Il était une fois nous', 'il-etait-une-fois-nous',
                "Avant les souvenirs que nous racontons aujourd'hui, il y avait simplement quelques enfants qui ne savaient pas encore qu'ils allaient grandir ensemble.",
                "Mais ce n'était que la première page…"],
            [2, 'Grandir ensemble', 'grandir-ensemble',
                'Puis, sans vraiment nous en rendre compte… nous avons grandi.',
                'Nous n\'étions plus les mêmes enfants. Mais nous étions toujours nous.'],
            [3, 'Nos délires', 'nos-delires',
                'Le rythme change. Place aux grimaces, aux surnoms et aux moments absurdes.',
                "On a beaucoup ri. Vraiment beaucoup. Mais notre histoire, ce n'est pas seulement les bons moments."],
            [4, 'Dans les bons comme dans les mauvais moments', 'bons-et-mauvais-moments',
                'Une ambiance plus calme pour les moments qui ont compté.',
                'Nous avons traversé des choses différentes. Mais nous ne les avons jamais vraiment traversées seuls.'],
            [5, 'Les années passent', 'les-annees-passent',
                '2008 → … → 2026. Et nous voilà aujourd\'hui.',
                'Le temps a changé beaucoup de choses. Mais il n\'a pas effacé notre histoire.'],
            [6, 'Une famille choisie', 'une-famille-choisie',
                "Chacun de nous, avec ses histoires, ses mots, sa place dans cette amitié.",
                'Différents caractères. Différentes histoires. Différentes vies. Mais une histoire à nous.'],
            [7, 'La suite de notre histoire', 'la-suite-de-notre-histoire',
                '2008 → 2010 → 2013 → 2016 → 2020 → 2023 → 2026…',
                "Ce n'est pas la fin. C'est simplement la prochaine page."],
        ];

        $chapters = collect($chaptersData)->map(function ($c) {
            [$number, $title, $slug, $intro, $outro] = $c;
            return Chapter::updateOrCreate(
                ['slug' => $slug],
                [
                    'number' => $number,
                    'title' => $title,
                    'intro_text' => $intro,
                    'outro_text' => $outro,
                    'sort_order' => $number,
                    'is_active' => true,
                ]
            );
        })->keyBy('slug');

        // --- Souvenirs de démonstration ----------------------------------------
        Memory::updateOrCreate(
            ['chapter_id' => $chapters['il-etait-une-fois-nous']->id, 'title' => '[DÉMO] Première photo de groupe'],
            [
                'year' => 2008,
                'description' => "Souvenir de démonstration. Remplacez cette fiche et sa photo depuis l'administration.",
                'anecdote' => 'Anecdote de démonstration.',
                'memory_type' => 'photo',
                'sort_order' => 1,
                'is_featured' => true,
                'is_active' => true,
            ]
        );

        Memory::updateOrCreate(
            ['chapter_id' => $chapters['grandir-ensemble']->id, 'title' => '[DÉMO] Avant / Maintenant'],
            [
                'year' => 2016,
                'description' => "Exemple de souvenir utilisant le slider avant/après.",
                'memory_type' => 'before_after',
                'sort_order' => 1,
                'is_active' => true,
            ]
        );

        Memory::updateOrCreate(
            ['chapter_id' => $chapters['nos-delires']->id, 'title' => '[DÉMO] Les poses'],
            [
                'year' => 2014,
                'category' => 'Les poses',
                'description' => 'Exemple de souvenir classé dans un dossier de délires.',
                'memory_type' => 'special',
                'sort_order' => 1,
                'is_active' => true,
            ]
        );

        // --- Messages personnels -------------------------------------------------
        if ($friends->count() >= 2) {
            PersonalMessage::updateOrCreate(
                [
                    'author_friend_id' => $friends[1]->id,
                    'recipient_friend_id' => $friends[0]->id,
                ],
                [
                    'content' => "[DÉMO] Message d'exemple : un mot plein de souvenirs pour toi.",
                    'is_visible' => true,
                ]
            );
        }

        // --- Capsule 2036 -------------------------------------------------------
        foreach ($friends as $friend) {
            TimeCapsule::updateOrCreate(
                ['friend_id' => $friend->id],
                [
                    'content' => "[DÉMO] Message laissé pour {$friend->name} dans le futur.",
                    'unlock_at' => now()->setDate((int) Setting::get('capsule_next_rendezvous_year', 2036), 1, 1),
                ]
            );
        }
    }
}
