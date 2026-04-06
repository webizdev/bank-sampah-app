import { drizzle } from 'drizzle-orm/mysql2';
import mysql from 'mysql2/promise';
import { categories, products } from './schema';

async function seed() {
  const connection = await mysql.createConnection({
    host: 'localhost',
    user: 'root',
    password: 'root',
    database: 'banksampah',
  });

  const db = drizzle(connection);

  console.log('Seeding categories...');
  const catRes = await db.insert(categories).values([
    { name: 'Plastik', slug: 'plastik', description: 'Sampah plastik', icon: 'local_drink' },
    { name: 'Kertas', slug: 'kertas', description: 'Sampah kertas', icon: 'description' },
    { name: 'Logam', slug: 'logam', description: 'Sampah logam', icon: 'hardware' },
  ]);

  console.log('Seeding products...');
  await db.insert(products).values([
    { category_id: 1, name: 'Botol PET Bening', slug: 'botol-pet', price_per_kg: '4500.00', icon: 'local_drink' },
    { category_id: 1, name: 'Gelas Plastik Bersih', slug: 'gelas-plastik', price_per_kg: '3500.00', icon: 'coffee' },
    { category_id: 2, name: 'Kardus Bekas', slug: 'kardus-bekas', price_per_kg: '2800.00', icon: 'inventory_2' },
  ]);

  console.log('Seed complete!');
  await connection.end();
}

seed().catch(console.error);
