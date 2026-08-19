# 📖 توثيق الـ API - تطبيق تشخيص الأمراض الجلدية بالذكاء الاصطناعي (Skin Disease Diagnosis API)

دليل شامل ومفصل لمطوري التطبيقات (Mobile Flutter / React Native / iOS / Android) ومطوري الويب (Frontend Web) للربط مع الخلفية البرمجية (Backend).

---

## 📌 1. معلومات عامة والاتصال (General Specifications)

- **Base URL:** `http://localhost:8000/api/v1` (أو رابط الـ Server الرئيسي في الإنتاج).
- **Default Format:** `application/json` لجميع الطلبات والاستجابات.
- **Image Upload Format:** `multipart/form-data` عند رفع صور الفحص الجلدي.
- **Authentication:** يتم استخدام **Laravel Sanctum**. يجب إرسال الـ Bearer Token في الـ Headers لجميع الطلبات المحمية:
  ```http
  Authorization: Bearer <YOUR_ACCESS_TOKEN>
  Accept: application/json
  ```

---

## 🔐 2. حسابات المستخدمين والمصادقة (Authentication Endpoints)

### 2.1 تسجيل حساب جديد (Register)
- **Endpoint:** `POST /api/v1/auth/register`
- **Headers:** `Accept: application/json`, `Content-Type: application/json`
- **Request Body:**
```json
{
  "name": "أحمد محمود",
  "email": "ahmed@example.com",
  "password": "Password123!",
  "password_confirmation": "Password123!",
  "role": "patient"
}
```
> **ملاحظة حول `role`:** قيمة اختيارية، تقبل `patient` (مريض) أو `doctor` (طبيب). القيمة الافتراضية هي `patient`.

- **Success Response (201 Created):**
```json
{
  "success": true,
  "message": "تم إنشاء الحساب بنجاح",
  "data": {
    "user": {
      "id": 1,
      "name": "أحمد محمود",
      "email": "ahmed@example.com",
      "roles": [
        "patient"
      ],
      "created_at": "2026-08-20T01:50:00.000000Z"
    },
    "token": "1|abcdef1234567890..."
  }
}
```

- **Validation Error Response (422 Unprocessable Entity):**
```json
{
  "message": "هذا البريد الإلكتروني مستخدم بالفعل",
  "errors": {
    "email": [
      "هذا البريد الإلكتروني مستخدم بالفعل"
    ]
  }
}
```

---

### 2.2 تسجيل الدخول (Login)
- **Endpoint:** `POST /api/v1/auth/login`
- **Headers:** `Accept: application/json`, `Content-Type: application/json`
- **Request Body:**
```json
{
  "email": "ahmed@example.com",
  "password": "Password123!"
}
```

- **Success Response (200 OK):**
```json
{
  "success": true,
  "message": "تم تسجيل الدخول بنجاح",
  "data": {
    "user": {
      "id": 1,
      "name": "أحمد محمود",
      "email": "ahmed@example.com",
      "roles": [
        "patient"
      ],
      "created_at": "2026-08-20T01:50:00.000000Z"
    },
    "token": "2|xyz987654321..."
  }
}
```

---

### 2.3 تسجيل الخروج (Logout)
- **Endpoint:** `POST /api/v1/auth/logout`
- **Headers:** `Authorization: Bearer <TOKEN>`, `Accept: application/json`

- **Success Response (200 OK):**
```json
{
  "success": true,
  "message": "تم تسجيل الخروج بنجاح",
  "data": null
}
```

---

### 2.4 الملف الشخصي (Profile)
- **Endpoint:** `GET /api/v1/auth/profile`
- **Headers:** `Authorization: Bearer <TOKEN>`, `Accept: application/json`

- **Success Response (200 OK):**
```json
{
  "success": true,
  "message": "بيانات الملف الشخصي",
  "data": {
    "id": 1,
    "name": "أحمد محمود",
    "email": "ahmed@example.com",
    "roles": [
      "patient"
    ],
    "created_at": "2026-08-20T01:50:00.000000Z"
  }
}
```

---

## 🩺 3. فحوصات وتشخيص الأمراض الجلدية (Skin Scan Diagnosis Endpoints)

### 3.1 رفع صورة وعمل فحص بالذكاء الاصطناعي (Upload Scan & Predict)
- **Endpoint:** `POST /api/v1/scans`
- **Headers:** `Authorization: Bearer <TOKEN>`, `Accept: application/json`, `Content-Type: multipart/form-data`
- **Form Body (FormData):**
  - `file`: (File - **مطلوب**) صورة العينة الجلدية المراد فحصها (صيغ مقبولة: `jpeg`, `png`, `jpg`, `webp` | أقصى حجم: `10MB`).
  - `tta`: (Boolean - **اختياري**) خيار Test-Time Augmentation (افتراضي: `true`).

- **Success Response (201 Created):**
```json
{
  "success": true,
  "message": "تم فحص الصورة وتشخيص الحالة بنجاح",
  "data": {
    "id": 15,
    "user_id": 1,
    "image_url": "http://localhost:8000/storage/diagnoses/550e8400-e29b-41d4-a716-446655440000.png",
    "predicted_class": "nv",
    "predicted_label": "Melanocytic nevi",
    "label_ar": "وحمات صبغية (شامة)",
    "is_malignant": false,
    "confidence": 0.989399,
    "confidence_percentage": "98.94%",
    "inference_time_ms": 141.29,
    "tta_used": true,
    "status": "completed",
    "status_label": "مكتمل",
    "error_message": null,
    "top_3": [
      {
        "class": "nv",
        "label": "Melanocytic nevi",
        "confidence": 0.989399
      },
      {
        "class": "mel",
        "label": "Melanoma",
        "confidence": 0.003657
      },
      {
        "class": "bcc",
        "label": "Basal cell carcinoma",
        "confidence": 0.002652
      }
    ],
    "raw_response": {
      "success": true,
      "filename": "skin_sample.png",
      "content_type": "image/png",
      "inference_time_ms": 141.29,
      "predicted_class": "nv",
      "predicted_label": "Melanocytic nevi",
      "confidence": 0.989399,
      "top_3": [
        { "class": "nv", "label": "Melanocytic nevi", "confidence": 0.989399 },
        { "class": "mel", "label": "Melanoma", "confidence": 0.003657 },
        { "class": "bcc", "label": "Basal cell carcinoma", "confidence": 0.002652 }
      ],
      "tta_used": true,
      "tta_views": 5
    },
    "created_at": "2026-08-20T01:52:00.000000Z",
    "updated_at": "2026-08-20T01:52:01.000000Z"
  }
}
```

---

### 3.2 عرض سجل الفحوصات (List Scans)
- **Endpoint:** `GET /api/v1/scans`
- **Headers:** `Authorization: Bearer <TOKEN>`, `Accept: application/json`
- **Query Parameters (اختيارية للتصفية والتقسيم):**
  - `status`: تصفية حسب حالة الفحص (`completed`, `pending`, `failed`).
  - `predicted_class`: تصفية حسب كود المرض (`nv`, `mel`, `bcc`, `bkl`, `akiec`).
  - `per_page`: عدد الفحوصات في الصفحة (مثال: `15`).

- **Success Response (200 OK):**
```json
{
  "success": true,
  "message": "قائمة فحوصات الأمراض الجلدية",
  "data": {
    "data": [
      {
        "id": 15,
        "user_id": 1,
        "image_url": "http://localhost:8000/storage/diagnoses/550e8400-e29b-41d4-a716-446655440000.png",
        "predicted_class": "nv",
        "predicted_label": "Melanocytic nevi",
        "label_ar": "وحمات صبغية (شامة)",
        "is_malignant": false,
        "confidence": 0.989399,
        "confidence_percentage": "98.94%",
        "inference_time_ms": 141.29,
        "tta_used": true,
        "status": "completed",
        "status_label": "مكتمل",
        "created_at": "2026-08-20T01:52:00.000000Z"
      }
    ],
    "pagination": {
      "total": 1,
      "count": 1,
      "per_page": 15,
      "current_page": 1,
      "total_pages": 1
    }
  }
}
```

---

### 3.3 عرض تفاصيل فحص محدد (Get Scan Details)
- **Endpoint:** `GET /api/v1/scans/{id}`
- **Headers:** `Authorization: Bearer <TOKEN>`, `Accept: application/json`

- **Success Response (200 OK):** يعيد كائن التشخيص الكامل شامل تفاصيل الـ `top_3` الـ `raw_response` الكاملة.

---

### 3.4 حذف فحص (Delete Scan)
- **Endpoint:** `DELETE /api/v1/scans/{id}`
- **Headers:** `Authorization: Bearer <TOKEN>`, `Accept: application/json`

- **Success Response (200 OK):**
```json
{
  "success": true,
  "message": "تم حذف الفحص والملفات المرتبطة به بنجاح",
  "data": null
}
```

---

## 🤖 4. معلومات حالة الموديل الخارجي (AI Model Status)

### 4.1 الاستعلام عن تشغيل الموديل (Model Info)
- **Endpoint:** `GET /api/v1/ai/info`
- **Headers:** `Accept: application/json`

- **Success Response (200 OK):**
```json
{
  "success": true,
  "message": "معلومات حالة موديل الذكاء الاصطناعي الخارجي",
  "data": {
    "status": "online",
    "details": {
      "model": "Skin-Disease-ResNet50",
      "status": "running"
    }
  }
}
```

---

## 📊 5. دليل الأكواد والقيم الثابتة (Enums Reference)

### 5.1 أكواد الأمراض الجلدية (`predicted_class`)
| الكود (`predicted_class`) | الاسم الإنجليزي (`predicted_label`) | الاسم العربي (`label_ar`) | خطير / سرطاني (`is_malignant`) |
| :--- | :--- | :--- | :--- |
| `akiec` | Actinic Keratoses and Intraepithelial Carcinoma | التقان السعفي وسرطان الخلايا الحرشوفية | ⚠️ نعم (`true`) |
| `bcc` | Basal Cell Carcinoma | سرطان الخلايا القاعدية | ⚠️ نعم (`true`) |
| `bkl` | Benign Keratosis-like Lesions | آفات التقرن الحميدة | 🟢 لا (`false`) |
| `nv` | Melanocytic Nevi | وحمات صبغية (شامة) | 🟢 لا (`false`) |
| `mel` | Melanoma | ورم قتامي (ميلانوما) | ⚠️ نعم (`true`) |

### 5.2 حالات الفحص (`status`)
- `pending`: الفحص جاري ومعالجة الصورة قيد الانتظار.
- `completed`: تم التشخيص بنجاح واستلام النتيجة كاملة من الذكاء الاصطناعي.
- `failed`: حدث خطأ في الاتصال بالخدمة الخارجية لموديل الذكاء الاصطناعي.
