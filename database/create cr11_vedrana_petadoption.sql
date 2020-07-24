DROP DATABASE IF EXISTS cr11_vedrana_petadoption;
CREATE DATABASE IF NOT EXISTS cr11_vedrana_petadoption;
USE cr11_vedrana_petadoption;

create table if not exists animals
(
    id            int                     not null auto_increment,
    name          varchar(50)             not null,
    date_of_birth date                    not null,
    image         varchar(250)            not null default 'image.jpg',
    size          enum ('small', 'large') not null,
    type          varchar(50)             not null,
    location      varchar(250)            not null,
    gender        enum ('female', 'male') not null,
    description   varchar(6000),
    hobbies       varchar(250),
        primary key (id)
);

create table if not exists users
(
    id         int                                  not null auto_increment,
    username   varchar(30)                          not null,
    useremail varchar(60)                          not null,
    userpass  varchar(225)                         not null,
    status     enum ('user', 'admin', 'superadmin') not null default 'user',
    primary key (id),
    unique key usermail (useremail)
);

insert into animals(name, date_of_birth, image, size, type, location, gender, hobbies, description)
values ('Leena', '2015-01-12', 'leena.jpg', 'small', 'cat', 'Mariahilfer Straße 115, Vienna', 'female',
        'chasing the rope, sleeping, pushing stuff of the shelve',
        'Leena arrived after her owner could no longer look after her and is now ready to find a new home to call her own. She is sweet needy little girl who enjoys her fuss and cuddles. She will give you a little nip if you ignore her too so she knows what she wants and that is to be the centre of attention. She would be prefer to live in a quiet all adult home as she can be a bit spooked of loud noises and become worried. Any person in the home will need to have had some previous cat care experience and she will appreciate a home that lets her flourish and provides her the care and affection she deserves. She will enjoy a garden but regardless of your working hours she will need a cat flap fitted so she can be free to explore her own patch on her own terms. With this in mind Leena has had her front right leg amputated so she will need easy access in and out of her home and garden so it is important you can provide a safe space to call home.'),
       ('Micky', '2010-05-10', 'micky.jpg', 'small', 'cat', 'Kärntner Straße 10, Vienna', 'male',
        'sleeping',
        'Mickie arrived after his owner passed away and he was found injured in the garden. He is fine now and is ready to find a new home to call his own. He is a friendly soul who has an outstanding moustache and likes his fuss and grub. He would be best suited to an all adult home as he is used to an older home and likes to go with the flow. He would enjoy a quiet home as he knows what he wants as he can nip if you touch him in the wrong spot. Any people in the home will need to have had some previous cat experience and he will appreciate a home that lets him be a cat and express normal behaviour. He will also enjoy a garden but must have a cat flap fitted if you work a full day so he can be free to explore his own patch on his own terms. Mickie has had a cat bite abscess treated as well as having a tooth extracted and is now fine.'),
       ('Cookie', '2019-12-10', 'cookie.jpg', 'small', 'dog', 'Boulevard 10, France', 'male',
        'chasing the ball, eating, digging up bones',
        'Fun-loving Cookie is an active and outgoing boy who craves human companionship. He''s looking for a dedicated and knowledgeable owner who has researched his breed type. They will need to have plenty of time on their hands to teach him all the basics and continue his ongoing socialisation.'),
       ('Bella Boo', '2002-02-01', 'bella boo.jpg', 'large', 'dog', 'Chinatown 10, Hong Kong', 'female',
        'sleeping',
        'Beautiful Bella Boo is a sensitive soul. It can take her a while to build an attachment with new people but once a bond has been built she becomes very attached and is extremely loyal. She''s calm and well-behaved but doesn''t cope with being left home alone so she''s looking for a committed and understanding owner who is at home during the day and will give her the time and space to settle in.'),
       ('Buddy', '1999-03-10', 'buddy.jpg', 'large', 'horse', 'Horsington street 21, Horsetown', 'male',
        'running',
        'Buddy is a 16.2h TB 21yrs old gelding born in New Zealand who retired from a successful UK racing career in 2005 and was with his new owner since then. He did local shows and hacking out then unfortunately in 2010 he became too ill to take care of him.'),
       ('Mr. Moo', '2017-08-19', 'mr moo.jpg', 'large', 'cow', 'Green Hills 234, Dublin', 'male',
        'grazing, chewing',
        'The iconic Highland cow is seen on many Kent Wildlife Trust reserves and is crucial in helping us achieve our conservation aims, clearing large areas of scrub and all manner of vegetation. They are handsome, docile and friendly herd animals and people love them.'),
       ('Alpi', '2018-12-10', 'alpi.jpg', 'large', 'alpaca', 'Grazing Hills 41, Greenland', 'male',
        'grazing, chewing, spitting',
        'This goofy looking animal will steal your heart.'),
       ('Lemmy', '2020-01-25', 'lemmy.jpg', 'small', 'lemur', 'Tree Boulevard 24, Madagascar', 'male',
        'sitting on a tree',
        'They are native only to the island of Madagascar. Most existing lemurs are small, have a pointed snout, large eyes, and a long tail. They chiefly live in trees (arboreal), and are active at night (nocturnal). Lemurs share resemblance with other primates, but evolved independently from monkeys and apes.'),
       ('Shee', '2019-09-10', 'shee.jpg', 'large', 'sheep', 'Grazing Hills 41, Greenland', 'female',
        'grazing, chewing, looking',
        'Contrary to popular belief, sheep are extremely intelligent animals capable of problem solving. They are considered to have a similar IQ level to cattle and are nearly as clever as pigs. Like various other species including humans, sheep make different vocalisations to communicate different emotions. They also display and recognise emotion by facial expressions. Sheep are known to self-medicate when they have some illnesses. They will eat specific plants when ill that can cure them. Sheep are precocial (highly independent from birth) and gregarious (like to be in a group). Female sheep (ewes) are very caring mothers and form deep bonds with their lambs that can recognise them by their call (bleat) when they wander too far away. Egyptians believed that sheep were sacred. They even had them mummified when they died, just like humans.'),
       ('JoJo', '2000-10-21', 'jojo.jpg', 'large', 'ape', 'Jungle Camp, Ibiza', 'male',
        'sitting in a tree, playing cards, eating bananas',
        'When we first found JoJo in 2009, he was just skin and bone. His body was bent and weak from a lifetime of a poor diet and living chained up over an open sewer. Today JoJo is a handsome adult, and a very active individual in his enclosure, swinging around and spinning on the ropes. At meal times, JoJo still loves to take as much food as possible up to the high hammock in his enclosure. JoJo is a highly intelligent orangutan and enjoys every enrichment we provide. He loves problem-solving and is very skilled at getting food out of the various puzzles our care staff have prepared for him. He is also able to communicate with the medical team if he feels unwell. If he has a small wound on his back or wrist, he will point it out to his carers when they are doing their rounds. Thank you for helping us care for JoJo.'),
       ('Toyah', '2012-04-05', 'toyah.jpg', 'small', 'dog', 'Landstraßer Hauptstraße 150, Vienna', 'female',
        'relaxing, sleeping, getting pets',
        'Toyah is a sensitive girl who is looking for understanding and very experienced owners to help give her further guidance and manage some of her behaviours. She needs a calm and quiet adult only household away from towns in a rural setting. She is nervous of strangers so adopters will need to be prepared to work closely with the animal behaviour and welfare advisor, and be prepared to put a few simple measures in place in the home if expecting visitors. Toyah is a strong willed dog who will need ongoing training and management around other dogs, so adopters will have realistic expectations with regard to taking her out and about with them. She loves toys and games and will make a fun and interactive companion. Toyah is affectionate, comical, playful and intelligent.'),
       ('Poppet', '2014-03-07', 'poppet.jpg', 'small', 'dog', 'Dog Street 10, Dogtown', 'female',
        'playing fetch',
        'Poppet would like a home where she can potter around with calm like-minded dogs, or have a nice fuss with her people. She is a lovely girl with a brilliant character that is sure to brighten up your day! She is currently in a foster home where she is getting five star treatment and enjoying the luxuries they have to offer. Any new owner will need to discuss her medical issues before they can take her home.')
;