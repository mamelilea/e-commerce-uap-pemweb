$baseUrl = "c:\laragon\www\e-commerce-kelompok-1\storage\app\public\products\bershka"

# Men Images
Invoke-WebRequest -Uri "https://static.bershka.net/assets/public/713f/59ee/a7d2416294db/3894baf28f04/05347352800-a4o/05347352800-a4o.jpg?ts=1748245289011&w=1920" -OutFile "$baseUrl\men-pants-1.jpg"
Invoke-WebRequest -Uri "https://static.bershka.net/assets/public/6851/fee3/767848eb905d/a6e191d8bdca/05371210428-a4o/05371210428-a4o.jpg?ts=1754317188598&w=850&f=auto" -OutFile "$baseUrl\men-pants-2.jpg"
Invoke-WebRequest -Uri "https://static.bershka.net/assets/public/fa3a/a031/c9c843b6a945/16ce0445cb84/08094116802-a4o/08094116802-a4o.jpg?ts=1755087506933&w=850&f=auto" -OutFile "$baseUrl\men-shirt-1.jpg"
Invoke-WebRequest -Uri "https://static.bershka.net/assets/public/5757/5349/e9604d698ee3/3916549bcce7/08041443400-a4o/08041443400-a4o.jpg?ts=1754490811462&w=850&f=auto" -OutFile "$baseUrl\men-shirt-2.jpg"
Invoke-WebRequest -Uri "https://static.bershka.net/assets/public/1eb8/f164/b09e43598f2b/326a7db3fe2b/12624669040-a4o/12624669040-a4o.jpg?ts=1758534901127&w=850&f=auto" -OutFile "$baseUrl\men-shoes-1.jpg"
Invoke-WebRequest -Uri "https://static.bershka.net/assets/public/afd4/c024/fa66445cb4c4/e088f74a6b86/12307664001-a4o/12307664001-a4o.jpg?ts=1754896166993&w=850&f=auto" -OutFile "$baseUrl\men-shoes-2.jpg"
Invoke-WebRequest -Uri "https://static.bershka.net/assets/public/5866/ec72/c90249c6ba83/54ffdd7943c1/04856668512-a4o/04856668512-a4o.jpg?ts=1746005092555&w=850&f=auto" -OutFile "$baseUrl\men-acc-1.jpg"

# Women Images
Invoke-WebRequest -Uri "https://static.bershka.net/assets/public/f2b8/5e5c/8c1a4a98819c/71d6349ce78d/01397335433-a4o/01397335433-a4o.jpg?ts=1738059179254&w=750&f=auto" -OutFile "$baseUrl\women-top-1.jpg"
Invoke-WebRequest -Uri "https://static.bershka.net/assets/public/e32f/b8aa/9fc9402a9a23/1df4e7ccc3b9/01521335800-a4o/01521335800-a4o.jpg?ts=1736843489551&w=750&f=auto" -OutFile "$baseUrl\women-top-2.jpg"
Invoke-WebRequest -Uri "https://static.bershka.net/assets/public/8d79/ca99/506b4367aafb/c86ed3fa31aa/05096727812-a4o/05096727812-a4o.jpg?ts=1737046153754&w=850&f=auto" -OutFile "$baseUrl\women-pants-1.jpg"
Invoke-WebRequest -Uri "https://static.bershka.net/assets/public/e22c/ea56/0904477c9f33/a07f80333ca2/11345460040-b/11345460040-b.jpg?ts=1752484825012&w=563&f=auto" -OutFile "$baseUrl\women-shoes-1.jpg"
Invoke-WebRequest -Uri "https://static.bershka.net/assets/public/ae32/efe5/f55c45478861/f8baffe6544e/11540664040-a4o/11540664040-a4o.jpg?ts=1750750664101&w=563&f=auto" -OutFile "$baseUrl\women-shoes-2.jpg"
Invoke-WebRequest -Uri "https://static.bershka.net/assets/public/32c4/7891/f20343a1b56f/11a8ba0bb6c4/11640560040-a4o/11640560040-a4o.jpg?ts=1737967401179&w=563&f=auto" -OutFile "$baseUrl\women-shoes-3.jpg"
Invoke-WebRequest -Uri "https://static.bershka.net/assets/public/009a/f51b/ad594da19c1d/06b96aad1563/04369626800-a4o/04369626800-a4o.jpg?ts=1753708977677&w=563&f=auto" -OutFile "$baseUrl\women-acc-1.jpg"
Invoke-WebRequest -Uri "https://static.bershka.net/assets/public/37ef/e37e/59404e2a8a71/9cca91ab795f/09376486302-a4o/09376486302-a4o.jpg?ts=1747752139544&w=850&f=auto" -OutFile "$baseUrl\women-acc-2.jpg"

Write-Host "Images downloaded successfully."
