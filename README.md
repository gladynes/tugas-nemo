tool yang di gunakan 
•	visual studio kode 
•	xampp
•	mysql 
bahasa perograman yang di gunakan  
•	php 
•	html 
Pembuatan database mengunakan mysql dengan terminal 
 
    Keren saya dalam penbuatan database saya mennggunakan xampp makan saya harus menyalakan xampp nanya terlebih dahulu ke meudian baru saya mengunakan command prompt untuk mengakses mysql sebenarnya ada cara lain yakni mengunakan phpMyAdmin yang sudah di sediakan oleh xampp 
   Untuk masuk ke mysql mengunakan commad rompt dapat mengunakan printah mysql -u (nama user di mysql kalok melum ada bisa mengunakan root yang merupakan bawan dari mysql ) -p (mysql -u root -p ) jika menggunakan root saat muncul untuk memasukan password lasung tekan enter saya karena tidak ada password 
   Saat sudah masuk langkah awal adalah membuat database baru jika belum ada karena saya belum memiliki nya maka saya membuat database baru dengan nama nemo dan sekaligus membuat user baru pada mysql
Perintah untuk membuat user baru pada mysql :
A.	CREATE USER 'nemo'@'localhost' IDENTIFIED BY 'glady123';
Pentah ini di gunakan untuk membuat user baru di localhost  dan dengan sandi glady123
B.	GRANT ALL PRIVILEGES ON mydatabase.* TO 'nemo'@'localhost';
                         Digunkan untuk memberikan hak mengunakan mysql ke pada user yang baru 
                         Di buat agar  dapat mengunakan mysql 
C.	FLUSH PRIVILEGES;
Perintah ini di gunakan untuk menjalan atau menetapkan user nemo bisa bisa berjalan atau berfungsing atau berjalan 
Langkah pembuatan table baru setelah sudah membuat user sysql baru di mysql 
Setelah membuat user baru maka selanjutnya login ke user mysql yang baru di buat di saya sudah keluar dari user root dan berpindah ke user nemo kemudian setelah ada di user nemo saya membuat database baru dengan nama web1
Commad yang di gunakan dalam pembuat database 
Create database web1;
Perintah tersebut di gunakan untuk membuat database baru setelah sudah di buat masuk ke tahapan pembuatan table untuk menyimpan data yang akan di gunakan user maupun admin untuk login  dan juga menyimpan data diri dari user dan admin 
Setalah tadi di buat serang di gunakan dengan mengunakan perintah use web1;
Untuk mengunakan database tersebut untuk membuat table, dalam pembuatan table mengunakan perintah ini :
A.	CREATE TABLE data_user (
               Perintah ini di gunakan untuk membuat table dengan nama data_user 
B.	id INT AUTO_INCREMENT PRIMARY KEY,
   digunakan untuk mebuat table id  secara otomatis dan tidak sama 
C.	nama VARCHAR(255) NOT NULL,
di gunkan untuk membuat table nama di pada datable database dan tidak boleh nol  
D.	 username VARCHAR(255) UNIQUE NOT NULL,
di gunkan untuk membuat table username di pada datable database  
E.	 email VARCHAR(255) UNIQUE NOT NULL,
di gunkan untuk membuat table email di pada datable database  
F.	password VARCHAR(255) NOT NULL,
 di gunkan untuk membuat table pasword di pada datable database  
G.	 alamat TEXT,
 di gunkan untuk membuat table alamat di pada datable database  
H.	  role ENUM('admin', 'user') NOT NULL DEFAULT 'user'
untuk membuat role 
);

Setelah table sudah di buat kemudian tinggal memasukan user dan data yang di perlukan 
INSERT INTO data_user (nama, username, email, password, alamat, role)
( insert into di gunakan untuk memasukan data ke table database yang di inginkan )
VALUES ('figo', 'figodb', 'figo@gmail.com', PASSWORD('figo123'), 'rumah', 'admin');
Tahah pembuatan web halaman login  dasbord admin dan user 
  Sebelum membuat halama halaman login tahap pertama membuat php untuk konesi ke database sebagai berikut ;
 
Pada gambar di atas merupakan contoh konesi ke database mengunakan php pejelasan dari program php di atas  pada bagian atas di mulai dari nomer 3  sampe dengan nomer  6 merupakan data yang di perlukan untuk dapat terhubung ke database kemudian nomer 9 berfungsi untuk mebuat konesi dengan database  pada nomer 12 if $con  -- > connect_error di gunakan untuk menampung error dari konesi ke mysql jika ada error akan di tampilkan 

Jika sudah bisa terhubung  ke database maka langkah selajutnya membuat halaman login pada halaman ini untuk login user perlu memasukan data berupa sandi dan username dengan system jika salah satu dari password atau username salah maka login tidak akan di anggap gagal namun jika kedua nya bernilai benar maka akan di arakan ke dasbaor sesuai dengan role yang di miliki jika user akan ke dasbord user dan jika memiliki role admin akan di arakan ke dasbord admin 
 

  
Ini adalah sintak php untuk membuat halaman login selain menggunakan html pada baris pertama terdapat perintah session_star(); yang di gunakan untuk memuali konesi dangan database dan mencatat log dan catatan tetang user name password keterangan login agak dapat di teruskan ke halaaman lain dari web app yang sedanga di buat , setalah itu ada juga include yang di gunakan untuk menhubuangkan sintak ini dengan database dan begitu juga sebalikanya  request method di gunakan untuk menerima atau mendapat kan input dari user yang berupa password dan username yang akan di gunakan untuk login kemdian ada bagian $post di gunakan untuk  menggambil atau menerimama inputan dari user 
 
Bagian ini berfungsi untuk melakukan kengecekan jika ada salah salah satu dari user atau password tidak di isi maka  akan menampilakan error yang di ambil dari htlm error bawan 
Kemudian jika kedua nya terisi maka akan di teruskan untuk apa kah user dan password itu ada di database namun sebelum itu  snitak di bawah ini akan mengambil data dari database terlebih dahulu 
 
Dengan mengunakan perintah mysql di atas yang di gunakan untuk megambil data user dan password dari database ke mudian akan di bandingkan jika hanya ada satu data nya sama makan benar dan user dapat login hal ini di lakukan di sintak berikut 
 
Yang berfungsi untuk melakukan pembadingan jika kedua  parameter password dan user name benar maka kan bernilai tru atau satu kemudian akan  juga akan di kalukan prosen pengecekan role dari user yang login apa kah dia adalah admin atau user apa bila dia user maka akan di lempar ke dasbord user begitu juga degan admin akan di lempar ke dasbord admin dengan sintak berikut 
 
Pada sintak ini di gunakan memastikan password yang masuk sesuai dan juga user name kemudian akan di catat pada progam php dengan session agar saat perpindah halaman user tidak perlu lagi melakukan verivfikasi  data lagi kenan datalogin nya sudah di simpan 
Kemudian pada sintak ini juga di lakukan pengecekaan apa kah yang melakukan login adalah admin atau user yakni pada pogram  user role   dengan  jika dia  memiliki role admin maka kan di arakan ke dasadmin.php jika bukan maka akan  di arakan ke userdas.php namun 
 
Ini adalah tampilan dari halaman login nya jika user belum memiliki akun  makan akan di arakan ke dasbord untuk membuat akun  jika sudah maka akan di lakukan pengarahan ke dasbord sesuai dengan role yang di meiliki  missal dia di role user maka akan di arakan ke dasbord user 
 
Ini adalah sintak dari halaman dasbrod user   
 Bagaina php dari halaman user 
 
Session_start(); di sini untuk memulai seson pada halaman ini dan mengahalikan session dari halaman login ke halaman user 
 
Sintak di atas di gunakan untuk megalikan jika user terdetesi  belum login dengan melakukan pengecekan pada data di session yang ada pada halama login jika sudah maka boleh masuk namun jika belum maka akan di kembalikan ke halaman login lalu exit di gunakan untuk menghentikan sesi pada halaman login 
  Kemudianan pada   di gunakan untuk melakukan pegecekan username yang login ke dasbord user jika sudah  maka akan di ambilkan data dari database berdasarkan user name yang sama yang ada pada database 
 
Dengan sintak mysql di atas untuk mengabil data pada database ke mudian akan di simpan pada $result kemudian  dan menyimpan data yang sudah di ambil dari datase akan di simpan di local yaitu pada 
 
Kemudian jika data tidak di temukan maka akan di alihkan kembali ke halaman login 
 
Di atas merupakan sintak untuk megarakan kembali ke dasbord user apa bila  data yang ada pada database tidak di temuakan 
Pada dasbord ini memiliki memiki fitur chat dengan antar user dan chat peribadi denga admin 
 
Ini adalah tampilan dari dasbord user  yang memiliki 2 fitur chat 
Ini adalah tampilan dari  chat dengan admin 
 
 
Langakah pertama dalam pembuatan halaman untuk chat ini adalah membuat database baru yang berguna untuk menyimpan data chat dari user atau admin dan meyediakan nomer yang di gunakan untuk terhubung dengan user lain atau admin 
CREATE TABLE messages (
(perintah ini di gunakan untuk membuat table baru dengan nama messages)
    id INT AUTO_INCREMENT PRIMARY KEY,
    ( perintah ini untuk membuat kolom untuk di yang berfunsi sebagai primary key agar setiap data yang di simpan memilki kuci yang di gunakan untuk membedakan yang di buat secara automatis dengan perintah auto )
    sender_id INT NOT NULL,
   (  sender_id ini di gunakan untuk meyimpan id dari pengirim pesan   dengan tambah berbentu interjer dan tidak boleh kosong )
    receiver_id INT NOT NULL,
    ( pada sintak di mysql di atas di gunkan untuk meyimpan  id dari penerima pesan int merupakakan tipe datanya kemudian not nuul itu menadakan bahwa kolom ini tidak boleh kesong )
    message TEXT,
       ( membuat kolom dengan nama message dan dengan tipe text )
    timestamp TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
   ( perintak ini di gunakan untuk membuat kolom untuk meyimpan data dari waktu pesan itu di buat 
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP
pada bagian ini di gunakan untuk membuat tanggal dan waktu pesan di buat otomatis di is ikan )
);
Sintak hph untuk halama chat admin 
 
Pada baris pertama terdapat sesson_start(); yang berguna untuk meneruskan dari seson halama sebelumnya  ke mudian pada baris berikut nya ada require untuk terhubung dengan  database  pada if  ini di gunakan  untuk melakukan pengecekana pada data user name apa kah terdaftar dan sudah login jika sudah maka bisa lanjut ke tahap selanjutnya namun jika belum  maka akan di lempar ke bali ke dasbord untuk login 
 
Pada bagian awal dari sintak ini di gunakan untuk mengabil user_id dari session dan meyimpan nya pada $sender_id yang berguna sebagi id pengirim pesan seperti nomer telfon untuk tanda pengenal , pada baris selajutnya terdapat $sql_admin = "SELECT id FROM data_user WHERE role = 'admin' LIMIT 1"; di gunakan untuk mengambil id user dengan role admin namun di batasi hanya satu user saja yang di panggil kemudian sintak di bawah nya digunakan untuk menjalanakan perintah snitak sql dengan mengunakan konesi ke database dengan $conn kemudian output dari database akan di simpan pada $result_admin 
Kemudian pada if akan memeriksa apa pada result_admin berhasil  mengambil datanya kemudaian pada sintak berikutnya output yang sudah di hasilkan kan di simpan pada $receiver_id sebagai id admin pada baris berikutnya jika admin tidak di temukan maka sintak akan berhenti dan mengeluarkan pesan error 
 
Pada sintak ini pada bagian awal akan mencari username admin dari database dengan panduan picarian menggunakan receiver_id Dari admin kemudian pada baris berikutnya di gunakan untuk mejalankan perintak dari sintak mysql di atas kemudian pada baris ke tiga di gunakan untuk melakukan inisialisasi pada variable $recever_name dengan nilai  default 
Kemudian pada if ini di gunakan untuk melakukan pemeriksaan apa kah query berhasil di lakukan dan melakukan penggembalian data pada baris selanjutnya di gunakan untuk mengambil hasil dari query dan di simpan pada $row_receiver  kemudian pada baris selanjutnya akan mengambil nama admin  dari array $row_receiver dan meyimpanya pada $receiver_ name 
 
Pada baris pertama di gunakan untuk mengecek apa request yang datang mengunakan metod post  ke  mudian pada baris kedua digunakan untuk mengabil pesan dari post lalu di simpan dalam parameter $message kemudian pada baris ke tiga di gunakan untuk meyimpan pesan yang di dapat dari from ke dalam database 
 
Pada sintak ini mengambil semua pesan yang di buat oleh user dangan user lain yang dia aja berkomunikasi kemudian pesan di urutkan dengan waktu  dangan created_at 


