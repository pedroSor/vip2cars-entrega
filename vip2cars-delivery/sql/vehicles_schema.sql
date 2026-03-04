-- Esquema SQL para tabla vehicles (VIP2CARS)
CREATE TABLE IF NOT EXISTS vehicles (
  id INTEGER PRIMARY KEY AUTOINCREMENT,
  placa TEXT NOT NULL,
  marca TEXT,
  modelo TEXT,
  anio TEXT,
  nombre TEXT,
  apellidos TEXT,
  documento TEXT,
  correo TEXT,
  telefono TEXT,
  created_at TEXT,
  updated_at TEXT
);
