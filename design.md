# Design System: E-Apotek (Bento Style)

Dokumen ini adalah panduan gaya (Design System) utama untuk aplikasi **E-Apotek**. Tujuannya adalah untuk menjaga konsistensi UI/UX selama proses pengembangan, menghindari desain "template AI", dan memastikan tampilan terasa premium, modern, dan profesional.

## 1. Core Identity & Typography

## 1. Skema Warna (Color Palette)

Identitas utama E-Apotek menggunakan perpaduan warna yang merepresentasikan kesan medis yang bersih, terpercaya, sekaligus dinamis.

- **Primary Color (Uniform Blue)**: `#122837` 
  - *Fungsi*: Warna utama untuk sidebar, tombol aksi utama, header, dan elemen aktif. Memberikan kesan tegas, tenang, dan premium.
- **Accent Color (Palest Yellow)**: `#FBFC09`
  - *Fungsi*: Warna aksen untuk menyorot elemen penting (ikon, notifikasi, efek hover, atau tombol CTA sekunder). Memberikan kontras yang sangat baik di atas Uniform Blue.
- **Background & Surface**: 
  - *Background Utama*: `#F8FAFC` (Slate 50) untuk area konten agar terasa bersih dan modern.
  - *Card/Bento Surface*: `#FFFFFF` (Putih murni) dengan bayangan halus (soft shadow).
- **Text**: 
  - *Primary Text*: `#0F172A` (Slate 900)
  - *Secondary Text*: `#64748B` (Slate 500)

## 2. Tipografi

- **Primary Font**: `Inter` (Google Fonts)
  - *Weight*: 400 (Regular), 500 (Medium), 600 (SemiBold), 700 (Bold), 800 (ExtraBold).
  - Pastikan menggunakan font *sans-serif* yang bersih agar terlihat profesional dan terbaca dengan baik di ukuran kecil (seperti data tabel medis).

### Konfigurasi Tailwind (tailwind.config.js)
Pastikan warna ini terdaftar di konfigurasi Tailwind:
```javascript
theme: {
  extend: {
    colors: {
      brand: {
        blue: '#122837',
        yellow: '#FBFC09',
      }
    },
    fontFamily: {
      sans: ['Inter', 'sans-serif'],
    }
  }
}
```

## 3. Layout: Bento Box UI

Desain dashboard dan halaman utama harus menganut gaya **Bento Grid** (terinspirasi dari kotak bento Jepang).

- **Ikonografi Minimalis**: Gunakan icon set yang konsisten (seperti Heroicons v2) dengan ketebalan garis (stroke) yang sama (`stroke-width="1.5"`). Jangan campur icon solid dan outline secara sembarangan.
- **Kepadatan Teks (Text Density)**: Hindari teks panjang yang menumpuk. Gunakan *font-weight* dan *color contrast* untuk membedakan hierarki (Misal: Angka Rp 50.000.000 sangat besar dan bold, label "Pendapatan Bulan Ini" kecil dan abu-abu).

## 5. Implementasi Tombol (Button)

- **Primary Button**: 
  - Background: `#128837` (`bg-brand-green`)
  - Text: White (`text-white`)
  - Radius: `rounded-xl`
  - Hover: Sedikit lebih gelap (`hover:brightness-90`) dan `hover:-translate-y-0.5`.
- **Secondary/Accent Button**:
  - Background: `#FBFC09` (`bg-brand-yellow`)
  - Text: Dark (`text-slate-900 font-semibold`)
  - Hover: Opasitas atau shadow *glow* kuning.
