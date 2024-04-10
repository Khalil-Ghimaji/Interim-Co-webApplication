insert into admin values(1,'admin','$2y$10$Yxen8bwv65eBIaz/vWhNQ.z2M2v1O5nlpg1X1eIoejEW7QO/TBWqO');
--password 'admin'

insert into clients (id, nom_utilisateur, mot_de_passe, email, nom, locale, numero_telephone)
values
    (1, 'saleh', '$2a$12$I8io5F.n9ibPHFAQM3pHGuHloVD.sOAgRovqUG3tHlNdvJWOsi4vy', 'saleh@gmail.com', 'Saleh', 'Soussa', 54619327),
    (2, 'amir', '$2a$12$pAm8U96dbkMnUCtZ7ieTSOlqkDaBoyV1xtTMyuXXkx4LHSieeNZMC', 'amir@gmail.com', 'Amir', 'Gabes', 33164225),
    (3, 'mohsen', '$2a$12$5kf2/LaLEkV7S0Fx3solHuoz6DFv8NpGO4jBafMKvXQaA6BOK3KRe', 'mohsen@gmail.com', 'Mohsen', 'Tunis', 99645322);
--first password 'saleh123'
--second password 'amir1999'
--third password 'mohsenmohsen'

insert into agentsdrh (id, nom_utilisateur, mot_de_passe, email, numero_telephone, nom, prenom)
values
    (1, 'A.Mahmoud', '$2a$12$1ps34Sa7rZlstc8GID/.1Oo.Jzvd2XRGq4Z11RV/RtlYX/SyJxcLe', 'mahmoud@gmail.com', 42153663, 'ABDELKADER', 'Mahmoud'),
    (2, '7san', '$2a$12$6ZiM60ocP/HphPQysjb5C.m7lHtAo5//cKHtrvXU1XD2mkuNBE3u6', 'hsan@gmail.com', 98635628, 'BEN AMOR', 'Hsan'),
    (3, 'Mr.Bourawi', '$2a$12$ubUJpndVRtZlm.RDUpyLWOe2hDp53YMgK.LG4IVF6VDq1AF2pqHZu', 'bourawi@gmail.com', 51710436, 'BOURAWI', 'Touhami');
--first password 'abdelkadermahmoud'
--second password '123456789'
--third password '01012010'

insert into competences (id, competence, niveau_competence, prix_estime)
values
    (1, 'Plomberie', 3, 30),
    (2, 'Cyber Security', 2, 35),
    (3, 'Web Development', 2, 10),
    (4, 'Boulangerie', 1, 15);

insert into employes (id, nom, prenom, email, date_inscription, adresse, numero_telephone)
values
    (1, 'Qadhi', 'Sonia', 'sonia.qadhi@gmail.com', '2010-02-02', 'Nabeul', 94665272),
    (2, 'Allaya', 'Malek', 'malek.allaya@gmail.com', '2016-03-05', 'Bizerte', 21554253),
    (3, 'Hesinne', 'Khaled', 'khaled.hesinne@gmail.com', '2012-12-12', 'Ain Drahem', 78854922);

insert into competence_employe (id_employe, id_competence)
values
    (1, 2),
    (1, 3),
    (2, 4),
    (3, 1),
    (3, 2),
    (3, 3);