-- Consolidated schema for delivery
-- vehicles table
-- (source: sql/vehicles_schema.sql)
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

-- surveys schema (included for completeness)
PRAGMA foreign_keys = ON;
CREATE TABLE IF NOT EXISTS surveys (
  id INTEGER PRIMARY KEY AUTOINCREMENT,
  title TEXT NOT NULL,
  description TEXT,
  created_at TEXT DEFAULT (datetime('now')),
  updated_at TEXT
);

CREATE TABLE IF NOT EXISTS questions (
  id INTEGER PRIMARY KEY AUTOINCREMENT,
  survey_id INTEGER NOT NULL,
  text TEXT NOT NULL,
  type TEXT NOT NULL DEFAULT 'text',
  required INTEGER NOT NULL DEFAULT 0,
  position INTEGER DEFAULT 0,
  created_at TEXT DEFAULT (datetime('now')),
  FOREIGN KEY (survey_id) REFERENCES surveys(id) ON DELETE CASCADE
);

CREATE TABLE IF NOT EXISTS options (
  id INTEGER PRIMARY KEY AUTOINCREMENT,
  question_id INTEGER NOT NULL,
  text TEXT NOT NULL,
  position INTEGER DEFAULT 0,
  FOREIGN KEY (question_id) REFERENCES questions(id) ON DELETE CASCADE
);

CREATE TABLE IF NOT EXISTS responses (
  id INTEGER PRIMARY KEY AUTOINCREMENT,
  survey_id INTEGER NOT NULL,
  submitted_at TEXT DEFAULT (datetime('now')),
  metadata TEXT,
  FOREIGN KEY (survey_id) REFERENCES surveys(id) ON DELETE CASCADE
);

CREATE TABLE IF NOT EXISTS answers (
  id INTEGER PRIMARY KEY AUTOINCREMENT,
  response_id INTEGER NOT NULL,
  question_id INTEGER NOT NULL,
  option_id INTEGER,
  text_value TEXT,
  created_at TEXT DEFAULT (datetime('now')),
  FOREIGN KEY (response_id) REFERENCES responses(id) ON DELETE CASCADE,
  FOREIGN KEY (question_id) REFERENCES questions(id) ON DELETE CASCADE,
  FOREIGN KEY (option_id) REFERENCES options(id) ON DELETE SET NULL
);
