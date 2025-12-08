# EcoProvider API Documentation

## Base URL
```
http://127.0.0.1:8001
```

## Endpoints

### 1. Get All News (JSON)
Endpoint untuk mendapatkan data berita dalam format JSON yang bisa di-consume oleh aplikasi lain.

**URL:** `/eco-news-data`  
**Method:** `GET`  
**Response:** JSON

**Query Parameters:**
- `search` (optional) - Kata kunci pencarian
- `category` (optional) - Filter berdasarkan kategori
- `page` (optional) - Nomor halaman untuk pagination

**Example Request:**
```
GET http://127.0.0.1:8001/eco-news-data
GET http://127.0.0.1:8001/eco-news-data?search=sampah
GET http://127.0.0.1:8001/eco-news-data?category=Teknologi
GET http://127.0.0.1:8001/eco-news-data?page=2
```

**Example Response:**
```json
{
    "success": true,
    "data": [
        {
            "id": 1,
            "title": "Program Bank Sampah Nasional Tingkatkan Partisipasi Warga",
            "summary": "Program Bank Sampah Nasional berhasil meningkatkan partisipasi masyarakat...",
            "content": "Program Bank Sampah Nasional yang diluncurkan pemerintah...",
            "category": "Pengelolaan Sampah",
            "thumbnail_url": "https://images.unsplash.com/photo-1532996122724...",
            "published_at": "2025-12-05T10:30:00.000000Z",
            "created_at": "2025-12-08T09:34:00.000000Z",
            "updated_at": "2025-12-08T09:34:00.000000Z"
        },
        // ... more news items
    ],
    "categories": [
        "Pengelolaan Sampah",
        "Daur Ulang",
        "Energi Terbarukan",
        "Teknologi",
        "Gaya Hidup"
    ],
    "pagination": {
        "current_page": 1,
        "last_page": 3,
        "per_page": 12,
        "total": 30
    }
}
```

### 2. Get News with UI (HTML)
Endpoint untuk menampilkan halaman berita dengan UI EcoProvider.

**URL:** `/eco-news-search`  
**Method:** `GET`  
**Response:** HTML Page

---

## Integration Example for BankSampahDigital

### Using PHP/Laravel
```php
use Illuminate\Support\Facades\Http;

public function ecoNews()
{
    try {
        $response = Http::get('http://127.0.0.1:8001/eco-news-data');
        
        if ($response->successful()) {
            $data = $response->json();
            $news = $data['data'];
            $categories = $data['categories'];
            $pagination = $data['pagination'];
        } else {
            $news = [];
            $categories = [];
            $pagination = [];
        }
    } catch (\Exception $e) {
        $news = [];
        $categories = [];
        $pagination = [];
    }
    
    return view('eco-news.index', compact('news', 'categories', 'pagination'));
}
```

### Using JavaScript/Fetch
```javascript
fetch('http://127.0.0.1:8001/eco-news-data')
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            const news = data.data;
            const categories = data.categories;
            // Render news dengan layout BankSampahDigital
            renderNews(news);
        }
    })
    .catch(error => {
        console.error('Error fetching news:', error);
    });
```

---

## CORS Configuration
CORS sudah dikonfigurasi untuk menerima request dari:
- `http://127.0.0.1:8000` (BankSampahDigital)
- `http://localhost:8000`

Jika perlu menambahkan origin lain, edit file `config/cors.php`
