import { mysqlTable, serial, varchar, text, decimal, timestamp, bigint, boolean } from 'drizzle-orm/mysql-core';

// 1. Tabel User & Auth
export const users = mysqlTable('users', {
  id: serial('id').primaryKey(),
  name: varchar('name', { length: 150 }).notNull(),
  whatsapp: varchar('whatsapp', { length: 20 }).notNull().unique(),
  email: varchar('email', { length: 150 }),
  password: varchar('password', { length: 255 }),
  role: varchar('role', { length: 20 }).default('USER'), // ADMIN, USER
  balance: decimal('balance', { precision: 12, scale: 2 }).default('0.00'),
  total_kg: decimal('total_kg', { precision: 10, scale: 2 }).default('0.00'),
  tier: varchar('tier', { length: 50 }).default('Bronze'), // Bronze, Silver, Gold, Platinum
  avatar_url: text('avatar_url'),
  organization: varchar('organization', { length: 100 }),
  bank_name: varchar('bank_name', { length: 100 }),
  account_number: varchar('account_number', { length: 50 }),
  latitude: decimal('latitude', { precision: 10, scale: 8 }),
  longitude: decimal('longitude', { precision: 11, scale: 8 }),
  address: text('address'),
  created_at: timestamp('created_at').defaultNow(),
});

// 2. Tabel Kategori Utama (Plastik, Kertas, Logam, dll)
export const categories = mysqlTable('categories', {
  id: serial('id').primaryKey(),
  name: varchar('name', { length: 100 }).notNull(),
  slug: varchar('slug', { length: 100 }).notNull(),
  description: text('description'),
  icon: varchar('icon', { length: 50 }),
  image_url: text('image_url'),
  is_popular: boolean('is_popular').default(true),
  created_at: timestamp('created_at').defaultNow(),
});

// 3. Tabel Produk Turunan (Botol PET, Kardus Bekas, dll)
export const products = mysqlTable('products', {
  id: serial('id').primaryKey(),
  category_id: bigint('category_id', { mode: 'number', unsigned: true }).references(() => categories.id),
  name: varchar('name', { length: 100 }).notNull(),
  slug: varchar('slug', { length: 100 }).notNull(),
  description: text('description'),
  price_per_kg: decimal('price_per_kg', { precision: 10, scale: 2 }).notNull(),
  icon: varchar('icon', { length: 50 }),
  image_url: text('image_url'),
  is_popular: boolean('is_popular').default(true),
  created_at: timestamp('created_at').defaultNow(),
});

// 4. Tabel Transaksi User (Waste Inbound)
export const transactions = mysqlTable('transactions', {
  id: serial('id').primaryKey(),
  user_id: bigint('user_id', { mode: 'number', unsigned: true }).references(() => users.id),
  product_id: bigint('product_id', { mode: 'number', unsigned: true }).references(() => products.id),
  weight_est: decimal('weight_est', { precision: 10, scale: 2 }).notNull(),
  weight_actual: decimal('weight_actual', { precision: 10, scale: 2 }),
  total_payout: decimal('total_payout', { precision: 10, scale: 2 }).notNull(),
  status: varchar('status', { length: 20 }).default('PENDING'), // PENDING, VERIFIED, COMPLETED, CANCELLED
  type: varchar('type', { length: 20 }).default('DROPOFF'), // DROPOFF, PICKUP
  address: text('address'),
  note: text('note'),
  created_at: timestamp('created_at').defaultNow(),
});

// 5. Tabel Penjualan Sampah ke Vendor (Waste Outbound)
export const sales = mysqlTable('sales', {
  id: serial('id').primaryKey(),
  product_id: bigint('product_id', { mode: 'number', unsigned: true }).references(() => products.id),
  weight_sold: decimal('weight_sold', { precision: 10, scale: 2 }).notNull(),
  price_per_kg: decimal('price_per_kg', { precision: 10, scale: 2 }).notNull(),
  total_price: decimal('total_price', { precision: 12, scale: 2 }).notNull(),
  buyer_name: varchar('buyer_name', { length: 150 }),
  status: varchar('status', { length: 20 }).default('COMPLETED'),
  created_at: timestamp('created_at').defaultNow(),
});

// 6. Tabel Konten/Artikel
export const content = mysqlTable('content', {
  id: serial('id').primaryKey(),
  title: varchar('title', { length: 255 }).notNull(),
  subtitle: varchar('subtitle', { length: 255 }),
  content: text('content'),
  category: varchar('category', { length: 50 }).default('BLOG'), // AGENDA, BLOG, EDUKASI
  event_date: timestamp('event_date'),
  location: varchar('location', { length: 255 }),
  cta_link: text('cta_link'),
  image_url: text('image_url'),
  status: varchar('status', { length: 20 }).default('PUBLISHED'),
  created_at: timestamp('created_at').defaultNow(),
});

// 7. Tabel Kerajinan (Crafts)
export const crafts = mysqlTable('crafts', {
  id: serial('id').primaryKey(),
  title: varchar('title', { length: 200 }).notNull(),
  price: decimal('price', { precision: 12, scale: 2 }).notNull(),
  description: text('description'),
  cta_link: text('cta_link'),
  image_url: text('image_url'),
  created_at: timestamp('created_at').defaultNow(),
});

// 8. Tabel Layanan (Services)
export const services = mysqlTable('services', {
  id: serial('id').primaryKey(),
  name: varchar('name', { length: 150 }).notNull(),
  description: text('description'),
  type: varchar('type', { length: 50 }),
  is_active: boolean('is_active').default(true),
  created_at: timestamp('created_at').defaultNow(),
});

// 9. Tabel Settings
export const settings = mysqlTable('settings', {
  id: serial('id').primaryKey(),
  setting_key: varchar('setting_key', { length: 100 }).unique().notNull(),
  setting_value: text('setting_value'),
  description: text('description'),
  updated_at: timestamp('updated_at').defaultNow().onUpdateNow(),
});
