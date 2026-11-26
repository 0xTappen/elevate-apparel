# Aset dan lisensi

- `public/images/branding/*.svg` dan `public/favicon.svg`: logo geometris SVG yang dibuat untuk proyek ini.
- `public/images/favicon/*`: favicon dan logo yang disediakan pengguna. Website memakai `favicon.ico`, PNG 16/32, Apple touch icon, dan web manifest dari folder ini.
- `public/images/products/*.svg` dan `public/images/categories/*.svg`: ilustrasi vektor orisinal dan representatif untuk data simulasi. Bukan foto atau portofolio pelanggan nyata.
- Font Inter Variable dan Space Grotesk Variable: paket `@fontsource-variable/inter` dan `@fontsource-variable/space-grotesk`, didistribusikan melalui npm dengan lisensi SIL Open Font License 1.1. Font disimpan dalam build Vite lokal.

Admin dapat mengganti visual representatif dengan foto produk yang memiliki izin penggunaan melalui formulir upload. File upload disimpan pada disk Laravel `public`.
