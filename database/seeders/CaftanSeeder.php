<?php

namespace Database\Seeders;

use App\Models\ObjetLouable;
use App\Models\User;
use App\Models\Photo;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CaftanSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Nettoyage radical pour éviter les doublons
        Photo::whereHas('objetLouable', function($q) {
            $q->where('type', 'caftan');
        })->delete();
        ObjetLouable::where('type', 'caftan')->delete();

        $admin = User::where('email', 'test@example.com')->first();
        $userId = $admin ? $admin->id : 1;

        // 2. Les 27 Caftans Réels avec leurs photos regroupées
        $caftans = [
            [
                'titre' => 'Caftan "Majesté Pourpre"',
                'description' => "Incarnez la grâce et le mystère avec ce caftan d'un prune profond absolument envoûtant. Réalisé dans un satin de soie luxueux.",
                'prix' => 550, 'localisation' => 'FES', 'taille' => 'Standard', 'couleur' => 'Prune', 'tissu' => 'Satin de soie haute couture',
                'photos' => ['photos/QaMlls8tqsFSemCgyIEw3wsBevQbrqzTl1iD8y1f.jpg', 'photos/GQKfOyCn2TLIRD8n3TdvKp2rX96WnJ6w85HqGM6f.jpg']
            ],
            [
                'titre' => 'Caftan "Sauge Royale"',
                'description' => "Alliez noblesse et fraîcheur avec ce caftan en satin de soie vert sauge. Sublimé par des broderies artisanales ton sur ton.",
                'prix' => 500, 'localisation' => 'MEKNES', 'taille' => 'Standard', 'couleur' => 'Vert d\'eau', 'tissu' => 'Satin de soie',
                'photos' => ['photos/Mhq2FTWxtE6t21UyRZnQZG8MCSyDwsdBnkIcIcZI.jpg', 'photos/1h0MeYPZKr1Va1Fabqv3b1KI7xNpdL9sn5ZJv5RB.jpg']
            ],
            [
                'titre' => 'Caftan "Émeraude & Or"',
                'description' => "L'alliance parfaite de la tradition et du luxe absolu. Velours émeraude épais orné de broderies dorées Maalem.",
                'prix' => 600, 'localisation' => 'FES', 'taille' => 'Standard', 'couleur' => 'Vert Émeraude / Or', 'tissu' => 'Velours de soie (Mobra) haut de gamme',
                'photos' => ['photos/BiCkDbv1wNc4EGzRKLnUk0UFWmo3oVxrRtPwgjIu.jpg', 'photos/EkIm7gPYlSN4dninWvrpjJHtolXjts1K18uBdNzt.jpg']
            ],
            [
                'titre' => 'Caftan "Fleur de Menthe"',
                'description' => "Douceur absolue en crêpe de soie vert menthe. Broderies florales ton sur ton et perlage délicat.",
                'prix' => 450, 'localisation' => 'FES', 'taille' => 'Standard', 'couleur' => 'Vert Menthe', 'tissu' => 'Crêpe de soie',
                'photos' => ['photos/Q5H3zJ3R481doTqgDhMZFSZ8nlrH39Q5iHXmW5Lp.jpg', 'photos/8VjQudBLL4zinM8ST37Z4cgruRafRgSSGByQkKwU.jpg']
            ],
            [
                'titre' => 'Caftan "Bronze Impérial"',
                'description' => "Élégance à l'état pur en velours chocolat profond. Broderies dorées Maalem majestueuses.",
                'prix' => 650, 'localisation' => 'MEKNES', 'taille' => 'Standard', 'couleur' => 'Chocolat profond / Bronze doré', 'tissu' => 'Velours de soie (Mobra) de première qualité',
                'photos' => ['photos/6AdRnrucRs9f9FvUMUJ7XYL4TxkYbDfkYfMGWGp5.jpg', 'photos/masjtQxEcCMcxxq5YOtxvAi0VTFTFxMBR5dLDb6z.jpg']
            ],
            [
                'titre' => 'Caftan "Nuit Boréale"',
                'description' => "Élégance contemporaine en satin vert paon avec broderies argentées géométriques.",
                'prix' => 500, 'localisation' => 'CASA', 'taille' => 'Standard', 'couleur' => 'Vert Paon', 'tissu' => 'Satin de soie de luxe',
                'photos' => ['photos/ediiYgFPfff4CVuJqoQlOq3jAbV6AlXKJEKhEq2H.jpg', 'photos/8tLSSMm5HwMcx4ShMYqsr44J38nAUMCGXwi09Hgi.jpg']
            ],
            [
                'titre' => 'Takchita "Éclat d\'Améthyste"',
                'description' => "Luxe et raffinement en duo velours violet profond et satin améthyste.",
                'prix' => 700, 'localisation' => 'CASA', 'taille' => 'Standard', 'couleur' => 'Violet Royal', 'tissu' => 'Duo Velours de soie et Satin lourd',
                'photos' => ['photos/9QlEx9AJOjQxHViC6y43JipooxY3n34BsPpBeHWA.jpg', 'photos/6TMA3cyBAyKfPfA0SUrONvgvBIog4hvZphN35Vhd.jpg']
            ],
            [
                'titre' => 'Caftan "Lumière Pastel"',
                'description' => "Jaune pastel délicat et solaire en crêpe de soie léger. Broderies florales dorées.",
                'prix' => 450, 'localisation' => 'MEKNES', 'taille' => 'Standard', 'couleur' => 'Jaune Pastel', 'tissu' => 'Crêpe de soie',
                'photos' => ['photos/QXQQicUpLT7uCVjIOt7FDDAQa9VorG0g7LYLGyLx.jpg', 'photos/EiGITUNxemssdrdWvwfmucHibzkmhHPKZfDZS7tt.jpg']
            ],
            [
                'titre' => 'Caftan "Éclat de Bronze"',
                'description' => "Satin de soie bronze noble. Buste recouvert de broderies dorées Maalem rappelant les parures antiques.",
                'prix' => 550, 'localisation' => 'RABAT', 'taille' => 'Standard', 'couleur' => 'Bronze', 'tissu' => 'Satin de soie lourd au fini métallique',
                'photos' => ['photos/9EIbnWkc9XbFd6HGaf6YYcTIF94VHBA9LqammSMn.jpg', 'photos/j0Qw0QT0gEcy9WujHIIYSFIrqz4GjYkuSAiNvNzW.jpg']
            ],
            [
                'titre' => 'Caftan "Café de Nuit"',
                'description' => "Velours chocolat noir avec col officier et ceinture dorée sculpturale. Élégance minimaliste.",
                'prix' => 600, 'localisation' => 'RABAT', 'taille' => 'Standard', 'couleur' => 'Chocolat Noir', 'tissu' => 'Velours de soie (Mobra) fini miroitant',
                'photos' => ['photos/i4vECOGPi953rwCJC7Km5SHtzVre8EMJhbfLoLaJ.jpg', 'photos/l8u8zD0PIU03cvt6TI0HKh1T7YgGP1YtPHEobmm0.jpg']
            ],
            [
                'titre' => 'Takchita "Aube Dorée"',
                'description' => "Vieux rose délicat et satin cuivré. Broderies or Maalem et ceinture sculpturale.",
                'prix' => 500, 'localisation' => 'FES', 'taille' => 'Standard', 'couleur' => 'Vieux Rose', 'tissu' => 'Duo Crêpe de soie et Satin irisé',
                'photos' => ['photos/hin0PCA9A5Icbz9cy6xxyk3pQulHzukocqxDaue5.jpg', 'photos/qw2m1rZaHHvxzOVlM1jzylzooUTq6HS2cMboBQms.jpg']
            ],
            [
                'titre' => 'Caftan "Rouge Rubis"',
                'description' => "Rouge incandescent en soie jacquard avec motifs floraux tissés. Allure incendiaire.",
                'prix' => 500, 'localisation' => 'TANGER', 'taille' => 'Standard', 'couleur' => 'Rouge Rubis', 'tissu' => 'Soie Jacquard',
                'photos' => ['photos/YR00Y1Ld8ASXv0z42GoKlWWMAXek4afse6yCz8aa.jpg', 'photos/uXcAfTTp8CJqiXkNn7yN2rO2RY0u6vv1bV3ZW5P4.jpg']
            ],
            [
                'titre' => 'Caftan "Soleil d\'Orient"',
                'description' => "Jaune canari vibrant en crêpe de soie avec broderies florales blanc écru.",
                'prix' => 450, 'localisation' => 'KENITRA', 'taille' => 'Standard', 'couleur' => 'Jaune Vif', 'tissu' => 'Crêpe de soie',
                'photos' => ['photos/jWOV2S9rag42oeMXoF6HKsDF9fm96maNWu2jEECX.jpg', 'photos/SYaEcdAeWNv3Eo03PzoeyN6mQtlIRGvtwVUYRAUQ.jpg']
            ],
            [
                'titre' => 'Caftan "Champagne Impérial"',
                'description' => "Velours de soie champagne avec broderies artisanales dorées et ceinture sculpturale.",
                'prix' => 600, 'localisation' => 'KENITRA', 'taille' => 'Standard', 'couleur' => 'Champagne', 'tissu' => 'Velours de soie (Mobra) au fini miroitant',
                'photos' => ['photos/DeOm5jpQ1XWYRbXZgVleMcCyv4GObMsp9L90k3RP.jpg', 'photos/8GHBMEmY9EuMSy0Sw6TcbQfrTiMSJSvzZJTg1kby.jpg']
            ],
            [
                'titre' => 'Caftan "Aurore de Velours"',
                'description' => "Fusion velours fuchsia et jupe plissée soleil dorée. Silhouette modernité absolue.",
                'prix' => 750, 'localisation' => 'CASA', 'taille' => 'Standard', 'couleur' => 'Fuchsia Profond', 'tissu' => 'Velours de soie et Tissu métallique plissé',
                'photos' => ['photos/zT2w4L19zWTHFQrYVTof7NMua5ni4pUGIwtCFxTU.jpg', 'photos/uiqJeUxd2mcth20YDw5ahKcyH2UuHauzi5RwJGmf.jpg']
            ],
            [
                'titre' => 'Caftan "Jardin d\'Oasis"',
                'description' => "Velours de soie vert mousse avec broderies florales ton sur ton d'une finesse incomparable.",
                'prix' => 600, 'localisation' => 'MEKNES', 'taille' => 'Standard', 'couleur' => 'Vert Mousse', 'tissu' => 'Velours de soie (Mobra) haut de gamme',
                'photos' => ['photos/EjbRKpWy35BDsg0bAnL13cC2vwgv73wbKGyvQNVx.jpg', 'photos/Xr6s1qBa1EfItjjKto2UUAKdfJgjNB4zXyfrrkty.jpg']
            ],
            [
                'titre' => 'Caftan "Éclipse Royale"',
                'description' => "Velours noir et jupe plissée soleil bronze antique. L'invitation au glamour oriental.",
                'prix' => 750, 'localisation' => 'RABAT', 'taille' => 'Standard', 'couleur' => 'Noir Intense', 'tissu' => 'Velours de soie et Tissu métallique plissé',
                'photos' => ['photos/WoR6O3kJgzN7ttBBeEb2KAUaVlW9F980PCeGW6Np.jpg', 'photos/UmyaNAZOoRKrX9ogvjCYdRa9Fy5ulc3zVNnxCBSP.jpg']
            ],
            [
                'titre' => 'Takchita "Rêve d\'Azur"',
                'description' => "Chiffon de soie bleu aqua léger avec broderies multicolores et dorées.",
                'prix' => 500, 'localisation' => 'FES', 'taille' => 'Standard', 'couleur' => 'Bleu Aqua', 'tissu' => 'Duo Chiffon de soie et Satin fluide',
                'photos' => ['photos/Qkt4KOlBcMgML3L0BGcAMkFuwMqKy01adKEQ7kt9.jpg', 'photos/B5dikgyuvrNO7Kvu1DSaLEIDldKGWsGNnzdj2xy1.jpg']
            ],
            [
                'titre' => 'Caftan "Rubis d\'Orient"',
                'description' => "Crêpe de soie lourd bordeaux avec broderies or Maalem. Noblesse et distinction.",
                'prix' => 500, 'localisation' => 'TANGER', 'taille' => 'Standard', 'couleur' => 'Bordeaux', 'tissu' => 'Crêpe de soie lourd fini mat',
                'photos' => ['photos/0y7YNM2fFIYsMSgoSNdDxSEtumoK8mvIDF3NATZ3.jpg', 'photos/Z3bIouiBPKNrxk9LPOm6JivaAqbIc3TPAmEM7eNk.jpg']
            ],
            [
                'titre' => 'Caftan "Éclat d\'Améthyste"',
                'description' => "Soie satinée violet électrique avec broderies argentées géométriques et florales.",
                'prix' => 500, 'localisation' => 'AGADIR', 'taille' => 'Standard', 'couleur' => 'Violet Électrique', 'tissu' => 'Soie Satinée',
                'photos' => ['photos/FsxgwngLnWBchOgyhFQodTENXKk2L4JAllQUROAE.jpg', 'photos/Ahb3uVxE63P3xwPDXQNhifi88cWA9G1tWHA2mkTu.jpg']
            ],
            [
                'titre' => 'Caftan "Douceur d\'Ivoire"',
                'description' => "Crêpe de soie crème avec broderies magenta et bordeaux. Subtilité et raffinement.",
                'prix' => 450, 'localisation' => 'AGADIR', 'taille' => 'Standard', 'couleur' => 'Crème', 'tissu' => 'Crêpe de soie léger',
                'photos' => ['photos/kVRmnJHWJ9rD5m3PjabVET5mnJiGuThgfYJgAORL.jpg', 'photos/uzSS7t74QMuY0vRZkuI4rBBiMpwlbd6x4HSJ3bkS.jpg', 'photos/3voVWJFjzxRreR4UmmgmpX58bm2sFQLYnBDU7i0Q.jpg']
            ],
            [
                'titre' => 'Caftan "Éclat de Corail"',
                'description' => "Rayonnez de fraîcheur avec ce caftan d'un corail vibrant. Broderies géométriques ton sur ton.",
                'prix' => 450, 'localisation' => 'MARRAKECH', 'taille' => 'Standard', 'couleur' => 'Corail', 'tissu' => 'Crêpe de soie premium',
                'photos' => ['photos/YmaazZO4NZ5DAko7eLdvErWXE8eDmw2RrR3Js4qY.jpg', 'photos/hfOziRWdlObpKxCkf6mz9GKdHTfDERwfmylqK4Jr.jpg']
            ],
            [
                'titre' => 'Caftan "Brise Argentée"',
                'description' => "Élégance discrète en bleu glacé. Broderies raffinées aux nuances argentées et lilas.",
                'prix' => 450, 'localisation' => 'FES', 'taille' => 'Standard', 'couleur' => 'Bleu glacé', 'tissu' => 'Crêpe de soie premium',
                'photos' => ['photos/v1K5Wz86CkFj9J8iyfVM3b2XOLhUdYLFBhQ540C1.jpg', 'photos/QpTUTPoWP3Drom3RL6TMF853EN4PpJd8G8z5xYl.jpg']
            ],
            [
                'titre' => 'Caftan "Lumière Safran"',
                'description' => "Éclatant et majestueux jaune safran avec de riches broderies vertes et dorées.",
                'prix' => 500, 'localisation' => 'MEKNES', 'taille' => 'Standard', 'couleur' => 'Jaune safran', 'tissu' => 'Crêpe de soie premium',
                'photos' => ['photos/WerURVMVX643eKPiavzyqqLh6BD6j2ItD8GXne79.jpg', 'photos/z1BR98DPXH0lf7efS3K2qQGxNRez0pzTIFu5Hwgh.jpg']
            ],
            [
                'titre' => 'Caftan "Émeraude Royale"',
                'description' => "Fusion de noblesse et de fraîcheur émeraude. Silhouette fluide et broderies dorées.",
                'prix' => 480, 'localisation' => 'CASA', 'taille' => 'Standard', 'couleur' => 'Vert Émeraude', 'tissu' => 'Crêpe de soie premium',
                'photos' => ['photos/Lev0n5XeU9ZIXqV3hvDuj2SanckpvpYCS7ATvHCD.jpg', 'photos/b1LVLs3wxChjhPFV9nEzd5TKFvtIxGBOAUdsxwMy.jpg']
            ],
            [
                'titre' => 'Caftan "Perle Dorée"',
                'description' => "Sobre, chic et intemporel beige doré. Éclat discret pour une allure distinguée.",
                'prix' => 430, 'localisation' => 'RABAT', 'taille' => 'Standard', 'couleur' => 'Beige doré', 'tissu' => 'Satin de soie premium',
                'photos' => ['photos/3voVWJFjzxRreR4UmmgmpX58bm2sFQLYnBDU7i0Q.jpg', 'photos/rJJpoF8xEZ8Q3IGzJMuibERLZJsvGXcSnHpYNTKk.jpg']
            ],
            [
                'titre' => 'Caftan "Neige Impériale"',
                'description' => "Pur et spectaculaire blanc ivoire. Détails floraux en relief sur le bas de la robe.",
                'prix' => 550, 'localisation' => 'TANGER', 'taille' => 'Standard', 'couleur' => 'Blanc ivoire', 'tissu' => 'Crêpe premium finitions 3D',
                'photos' => ['photos/dDXe8YplTEPc5RVaBIYOctA508eepP90DwCw8KYp.jpg', 'photos/VQkAR6vPeUdBA3T3RNhrLG7YcC70ItUxKbYj3CrO.jpg']
            ],
        ];

        foreach ($caftans as $data) {
            $photos = $data['photos'];
            unset($data['photos']);

            $caftan = ObjetLouable::create(array_merge($data, [
                'user_id' => $userId,
                'type' => 'caftan',
                'statut' => 'approuve',
            ]));

            foreach ($photos as $url) {
                Photo::create([
                    'objet_louable_id' => $caftan->id,
                    'url_photo' => $url,
                    'description' => 'Vue de ' . $caftan->titre
                ]);
            }
        }
    }
}
