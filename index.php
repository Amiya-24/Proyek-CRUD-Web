<?php
require 'config/database.php';
require 'templates/header.php';

$data_per_halaman = 5;
$halaman_aktif = isset($_GET['halaman']) ? (int)$_GET['halaman'] : 1;
$offset = ($halaman_aktif - 1) * $data_per_halaman;

$keyword = isset($_GET['keyword']) ? $_GET['keyword'] : '';
$params = [];

$sql = "SELECT * FROM barang";
$sql_total = "SELECT COUNT(*) FROM barang";

if (!empty($keyword)) {
    $where_clause = " WHERE nama_barang LIKE ? OR sku LIKE ?";
    $sql .= $where_clause;
    $sql_total .= $where_clause;
    $params[] = "%$keyword%";
    $params[] = "%$keyword%";
}

$sql .= " ORDER BY created_at DESC";

$stmt_total = $pdo->prepare($sql_total);
$stmt_total->execute($params);
$total_data = $stmt_total->fetchColumn();
$total_halaman = ceil($total_data / $data_per_halaman);


$sql .= " LIMIT " . (int)$data_per_halaman . " OFFSET " . (int)$offset;

$stmt = $pdo->prepare($sql);
$stmt->execute($params);
$barangs = $stmt->fetchAll();

?>

<h2>Daftar Barang Gudang</h2>

<form action="index.php" method="GET" class="form-cari">
    <input type="text" name="keyword" placeholder="Cari nama barang atau SKU..." value="<?php echo htmlspecialchars($keyword); ?>">
    <button type="submit">Cari</button>
</form>

<table>
    <thead>
        <tr>
            <th>Nama Barang</th>
            <th>SKU</th>
            <th>Stok</th>
            <th>Lokasi</th>
            <th>Dibuat Pada</th>
            <th>Aksi</th>
        </tr>
    </thead>
    <tbody>
        <?php if (empty($barangs)): ?>
            <tr>
                <td colspan="6">Belum ada barang.</td>
            </tr>
        <?php else: ?>
            <?php foreach ($barangs as $barang): ?>
                <tr>
                    <td><?php echo e($barang['nama_barang']); ?></td>
                    <td><?php echo e($barang['sku']); ?></td>
                    <td><?php echo e($barang['stok']); ?></td>
                    <td><?php echo e($barang['lokasi']); ?></td>
                    <td><?php echo date('d M Y H:i', strtotime($barang['created_at'])); ?></td>
                    <td class="aksi">
                        <a href="read.php?id=<?php echo $barang['id']; ?>" class="btn-detail">Detail</a>
                        <a href="update.php?id=<?php echo $barang['id']; ?>" class="btn-edit">Edit</a>
                        <a href="delete.php?id=<?php echo $barang['id']; ?>" class="btn-hapus" onclick="return confirm('Yakin?');">
                        Hapus
                        </a>
                    </td>
                </tr>
            <?php endforeach; ?>
        <?php endif; ?>
    </tbody>
</table>

<div class="pagination">
    <?php if ($halaman_aktif > 1): ?>
        <a href="?halaman=<?php echo $halaman_aktif - 1; ?>&keyword=<?php echo urlencode($keyword); ?>">&laquo;</a>
    <?php endif; ?>

    <?php for ($i = 1; $i <= $total_halaman; $i++): ?>
        <a href="?halaman=<?php echo $i; ?>&keyword=<?php echo urlencode($keyword); ?>" 
           class="<?php echo ($i == $halaman_aktif) ? 'active' : ''; ?>">
           <?php echo $i; ?>
        </a>
    <?php endfor; ?>

    <?php if ($halaman_aktif < $total_halaman): ?>
        <a href="?halaman=<?php echo $halaman_aktif + 1; ?>&keyword=<?php echo urlencode($keyword); ?>">&raquo;</a>
    <?php endif; ?>
</div>


<?php
require 'templates/footer.php';
?>