<a name="readme-top"></a>


[![Contributors][contributors-shield]][contributors-url]
[![Forks][forks-shield]][forks-url]
[![Stargazers][stars-shield]][stars-url]
[![Issues][issues-shield]][issues-url]


<br />
<div align="center">
  <a href="https://github.com/idoalit/slims-dts-islam">
    <img src="assets/taxonomy.png" alt="Logo" width="80" height="80">
  </a>

<h3 align="center">DTS Islam</h3>

  <p align="center">
    Plugin SLiMS untuk memanfaatkan Daftar Tajuk Subjek Islam dan Klasifikasi Islam yang diterbitkan oleh Perpustakaan Nasional RI tahun 2017.
    <br />
    <a href="assets/Daftar-Tajuk-Subjek-Islam-dan-Klasifikasi-Islam.pdf"><strong>Lihat dokumen DTS »</strong></a>
    <br />
    <br />
    <a href="https://github.com/idoalit/slims-dts-islam">View Demo</a>
    ·
    <a href="https://github.com/idoalit/slims-dts-islam/issues">Report Bug</a>
    ·
    <a href="https://github.com/idoalit/slims-dts-islam/issues">Request Feature</a>
  </p>
</div>



<!-- TABLE OF CONTENTS -->
<details>
  <summary>Table of Contents</summary>
  <ol>
    <li>
      <a href="#about-the-project">About The Project</a>
      <ul>
        <li><a href="#built-with">Built With</a></li>
      </ul>
    </li>
    <li>
      <a href="#getting-started">Getting Started</a>
      <ul>
        <li><a href="#prerequisites">Prerequisites</a></li>
        <li><a href="#installation">Installation</a></li>
      </ul>
    </li>
    <li><a href="#usage">Usage</a></li>
    <li><a href="#license">License</a></li>
  </ol>
</details>



<!-- ABOUT THE PROJECT -->
## About The Project

[![DTS Islam Screen Shot][product-screenshot]](https://github.com/idoalit/slims-dts-islam)

Ini merupakan proyek kolaborasi antara [Waris Agung Widodo](https://github.com/idoalit) dan [Danang Dwijo Kangko](https://scholar.google.com/citations?user=hoMWar4AAAAJ&hl=id)

<p align="right">(<a href="#readme-top">back to top</a>)</p>

<!-- GETTING STARTED -->
## Getting Started

Untuk dapat menggunakan plugin ini, harap ikuti langkah-langkah berikut.

### Prerequisites

Pastikan kamu memiliki aplikasi-aplikasi berikut untuk dapat memanfaatkan plugin DTS Islam.

* SLiMS v9.6.1
  ```sh
  git clone https://github.com/slims/slims9_bulian
  ```

* PHP Composer, silahkan baca bagaimana cara installnya di [getcomposer.org](https://getcomposer.org/)


### Installation

1. [Download](https://github.com/idoalit/slims-dts-islam/archive/refs/heads/main.zip) atau clone repositori ini
   ```sh
   git clone https://github.com/idoalit/slims-dts-islam.git
   ```
2. Ekstrak dan pindahkan hasil ekstrak / clone ke folder `plugins` pada SLiMS kamu

3. Jalankan `composer install` via terminal
    ```sh
    # masuk ke folder plugin dts islam
    cd slims9_bulian/plugins/slims-dts-islam
    
    # jalankan composer install
    composer install
    ```
4. Masuk pustakawan sebagai Administrator (user_id `1`)
5. Aktifkan plugin pada menu Sistem > Plugins

<p align="right">(<a href="#readme-top">back to top</a>)</p>



## Usage

Setelah plugin aktif, pada module _Master File_ (Daftar Terkendalai) terdapat menu baru `DTS Islam`

_Untuk contoh penggunaan lebih lengkap, silahkan baca pada [Dokumentasi](https://github.com/idoalit/slims-dts-islam/wiki)_

<p align="right">(<a href="#readme-top">back to top</a>)</p>


<!-- LICENSE -->
## License

Distributed under the GNU GPL v3 License. See `LICENSE.txt` for more information.

<p align="right">(<a href="#readme-top">back to top</a>)</p>

<!-- ACKNOWLEDGMENTS -->
## Acknowledgments

[Taxonomy icons created by Talha Dogar - Flaticon](https://www.flaticon.com/free-icons/taxonomy)


<!-- MARKDOWN LINKS & IMAGES -->
[contributors-shield]: https://img.shields.io/github/contributors/idoalit/slims-dts-islam.svg?style=for-the-badge
[contributors-url]: https://github.com/idoalit/slims-dts-islam/graphs/contributors
[forks-shield]: https://img.shields.io/github/forks/idoalit/slims-dts-islam.svg?style=for-the-badge
[forks-url]: https://github.com/idoalit/slims-dts-islam/network/members
[stars-shield]: https://img.shields.io/github/stars/idoalit/slims-dts-islam.svg?style=for-the-badge
[stars-url]: https://github.com/idoalit/slims-dts-islam/stargazers
[issues-shield]: https://img.shields.io/github/issues/idoalit/slims-dts-islam.svg?style=for-the-badge
[issues-url]: https://github.com/idoalit/slims-dts-islam/issues
[license-shield]: https://img.shields.io/github/license/idoalit/slims-dts-islam.svg?style=for-the-badge
[license-url]: https://github.com/idoalit/slims-dts-islam/blob/master/LICENSE.txt
[product-screenshot]: assets/screenshot.png