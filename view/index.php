<?php
require_once('../load.php');

use Controller\Employee;

$employee = new Employee();
$allEmployee = $employee->getAllEmployee();
$firstEmployee = $employee->getFirstEmployee($allEmployee);
$position = $employee->getAllPosition($allEmployee);

$query1 = "SELECT `no`, `name`, `start_date`, `salary`
FROM `employee`
WHERE `salary` BETWEEN 15000 and 25000";
$answer1 = $employee->getEmployeeByQuery($query1);

$query2 = "SELECT `no`, `name`, `salary`, `position`
FROM `employee`
WHERE `position` IN ('Manager', 'Supervisor')";
$answer2 = $employee->getEmployeeByQuery($query2);

$query3 = "SELECT e.`no`, e.`name`, e.`salary`, e.`dep_no`, d.`name` AS department, d.`location` AS location
FROM `employee` AS e
LEFT JOIN `department` AS d
ON e.`dep_no` = d.`no`";
$answer3 = $employee->getEmployeeByQuery($query3);

$query4 = "SELECT `no`, `name`, `salary`, `dep_no`
FROM `employee`
WHERE `dep_no` = (SELECT `dep_no` FROM `employee` WHERE `name` = 'Surasit')";
$answer4 = $employee->getEmployeeByQuery($query4);

$query5 = "SELECT d.`no`, d.`name`, SUM(e.`salary`) AS sum_salary
FROM `department` AS d
LEFT JOIN `employee` AS e
ON e.`dep_no` = d.`no`
GROUP BY d.`no`
HAVING COUNT(e.`no`) > 0";
$answer5 = $employee->getEmployeeByQuery($query5);

$query6 = "SELECT d.`no`, d.`name`, COUNT(e.`no`) AS num_employee
FROM `department` AS d
LEFT JOIN `employee` AS e
ON e.`dep_no` = d.`no`
WHERE d.`name` = 'Accounting'
GROUP BY d.`no`";
$answer6 = $employee->getEmployeeByQuery($query6);

$query7 = "SELECT `no`, `name`, `salary`, (`salary` * 1.5) AS new_salary
FROM `employee`";
$answer7 = $employee->getEmployeeByQuery($query7);

layoutHeader('Home')
?>

<div class="container my-5">
  <div class="row p-4 align-items-center rounded-3 border shadow-lg">
    <h4 class="text-body-emphasis">จงเขียนโปรแกรมเพื่อนำข้อมูลพนักงานทุกคนจาก Table Employee มาเก็บไว้ หลังจากนั้นให้แสดงชื่อพนักงานคนแรกบน Page</h4>

    <h5 class="mt-2 text-center">พนักงานทั้งหมด</h5>
    <table class="table table-dark table-bordered table-striped table-hover mt-2">
      <thead>
        <tr>
          <th>EmpNum</th>
          <th>EmpName</th>
          <th>HireDate</th>
          <th>Salary</th>
          <th>Position</th>
          <th>DepNo</th>
          <th>DepName</th>
          <th>DepLocation</th>
          <th>HeadNo</th>
        </tr>
      </thead>
      <tbody>
        <?php foreach ($allEmployee as $item) : ?>
          <tr>
            <td><?php echo $item['no'] ?></td>
            <td><?php echo $item['name'] ?></td>
            <td><?php echo $item['start_date'] ?></td>
            <td><?php echo $item['salary'] ?></td>
            <td><?php echo $item['position'] ?></td>
            <td><?php echo $item['dep_no'] ?></td>
            <td><?php echo $item['department'] ?></td>
            <td><?php echo $item['location'] ?></td>
            <td><?php echo $item['head_no'] ?></td>
          </tr>
        <?php endforeach; ?>
      </tbody>
    </table>

    <h5 class="mt-2 text-center">พนักงานคนแรก</h5>
    <table class="table table-dark table-bordered table-striped table-hover mt-2">
      <thead>
        <tr>
          <th>EmpNum</th>
          <th>EmpName</th>
          <th>HireDate</th>
          <th>Salary</th>
          <th>Position</th>
          <th>DepNo</th>
          <th>DepName</th>
          <th>DepLocation</th>
          <th>HeadNo</th>
        </tr>
      </thead>
      <tbody>
        <tr>
          <td><?php echo $firstEmployee['no'] ?></td>
          <td><?php echo $firstEmployee['name'] ?></td>
          <td><?php echo $firstEmployee['start_date'] ?></td>
          <td><?php echo $firstEmployee['salary'] ?></td>
          <td><?php echo $firstEmployee['position'] ?></td>
          <td><?php echo $firstEmployee['dep_no'] ?></td>
          <td><?php echo $firstEmployee['department'] ?></td>
          <td><?php echo $firstEmployee['location'] ?></td>
          <td><?php echo $firstEmployee['head_no'] ?></td>
        </tr>
      </tbody>
    </table>
  </div>
  <div class="row p-4 align-items-center rounded-3 border shadow-lg mt-5">
    <h4 class="text-body-emphasis">จงเขียนโปรแกรมเพื่อให้ผู้ใช้งานกรอกข้อมูลพนักงานบน Page จากนั้นนำมาบันทึกเพิ่มที่ Table Employee</h4>
    <form id="formAddEmployee" method="POST" action="/insert.php">
      <div class="mb-3">
        <label for="empNum" class="form-label">รหัสพนักงาน</label>
        <input type="text" name="no" class="form-control" id="empNum">
      </div>
      <div class="mb-3">
        <label for="empName" class="form-label">ชื่อพนักงาน</label>
        <input type="text" name="name" class="form-control" id="empName">
      </div>

      <div class="mb-3">
        <label for="empPosition" class="form-label">ตำแหน่ง</label>
        <select class="form-select" id="empPosition" name="position">
          <option value="" selected>เลือกตำแหน่ง</option>
          <?php foreach ($position as $item) : ?>
            <option value="<?php echo $item; ?>"><?php echo $item; ?></option>
          <?php endforeach; ?>
        </select>
      </div>


      <button type="submit" class="btn btn-primary" name="submitAddEmployee">เพิ่มพนักงาน</button>
    </form>
  </div>

  <div class="row p-4 align-items-center rounded-3 border shadow-lg mt-5">
    <h4 class="text-body-emphasis">จงเขียน SQL Command เพื่อแสดงคอลัมน์รหัสพนักงาน, ชื่อพนักงาน, วันที่เริ่มทำงาน, เงินเดือน โดยแสดงข้อมูลเฉพาะพนักงานที่มีเงินเดือนตั้งแต่ 15,000 ถึง 25,000 บาท</h4>
    <p>
      <mark>SELECT</mark> `no`, `name`, `start_date`, `salary` <br />
      <mark>FROM</mark> `employee` <br />
      <mark>WHERE</mark> `salary` <mark>BETWEEN</mark> 15000 and 25000
    </p>
    <table class="table table-dark table-bordered table-striped table-hover mt-2">
      <thead>
        <tr>
          <th>EmpNum</th>
          <th>EmpName</th>
          <th>HireDate</th>
          <th>Salary</th>
        </tr>
      </thead>
      <tbody>
        <?php foreach ($answer1 as $item) : ?>
          <tr>
            <td><?php echo $item['no'] ?></td>
            <td><?php echo $item['name'] ?></td>
            <td><?php echo $item['start_date'] ?></td>
            <td><?php echo $item['salary'] ?></td>
          </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
  </div>

  <div class="row p-4 align-items-center rounded-3 border shadow-lg mt-5">
    <h4 class="text-body-emphasis">จงเขียน SQL Command เพื่อแสดงคอลัมน์รหัสพนักงาน, ชื่อพนักงาน, เงินเดือน, ตำแหน่ง โดยแสดงข้อมูลเฉพาะพนักงานที่มีตำแหน่งเป็น Manager หรือ Supervisor และมีเงินเดือนมากกว่า 27,000 บาท</h4>
    <p>
      <mark>SELECT</mark> `no`, `name`, `salary`, `position` <br />
      <mark>FROM</mark> `employee` <br />
      <mark>WHERE</mark> `position` <mark>IN</mark> ("Manager", "Supervisor")
    </p>
    <table class="table table-dark table-bordered table-striped table-hover mt-2">
      <thead>
        <tr>
          <th>EmpNum</th>
          <th>EmpName</th>
          <th>Salary</th>
          <th>Position</th>
        </tr>
      </thead>
      <tbody>
        <?php foreach ($answer2 as $item) : ?>
          <tr>
            <td><?php echo $item['no'] ?></td>
            <td><?php echo $item['name'] ?></td>
            <td><?php echo $item['salary'] ?></td>
            <td><?php echo $item['position'] ?></td>
          </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
  </div>

  <div class="row p-4 align-items-center rounded-3 border shadow-lg mt-5">
    <h4 class="text-body-emphasis">จงเขียน SQL Command เพื่อแสดงคอลัมน์รหัสพนักงาน, ชื่อพนักงาน, รหัสแผนก, ชื่อแผนก, สถานที่</h4>
    <p>
      SELECT e.`no`, e.`name`, e.`dep_no`, d.`name` AS department, d.`location` AS location <br />
      FROM `employee` AS e <br />
      LEFT JOIN `department` AS d <br />
      ON e.`dep_no` = d.`no`
    </p>
    <table class="table table-dark table-bordered table-striped table-hover mt-2">
      <thead>
        <tr>
          <th>EmpNum</th>
          <th>EmpName</th>
          <th>Department No</th>
          <th>Department</th>
          <th>Location</th>
        </tr>
      </thead>
      <tbody>
        <?php foreach ($answer3 as $item) : ?>
          <tr>
            <td><?php echo $item['no'] ?></td>
            <td><?php echo $item['name'] ?></td>
            <td><?php echo $item['dep_no'] ?></td>
            <td><?php echo $item['department'] ?></td>
            <td><?php echo $item['location'] ?></td>
          </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
  </div>

  <div class="row p-4 align-items-center rounded-3 border shadow-lg mt-5">
    <h4 class="text-body-emphasis">จงเขียน SQL Command เพื่อแสดงคอลัมน์ชื่อพนักงาน, เงินเดือน, รหัสแผนก โดยแสดงข้อมูลเฉพาะพนักงานที่มีตำแหน่งงานเดียวกับพนักงานที่ชื่อ Surasit (สมมติว่าไม่ทราบตำแหน่งงานของพนักงานที่ชื่อ Surasit)</h4>
    <p>
      SELECT `no`, `name`, `salary`, `dep_no`<br />
      FROM `employee` <br />
      WHERE `dep_no` = (SELECT `dep_no` FROM `employee` WHERE `name` = "Surasit")
    </p>
    <table class="table table-dark table-bordered table-striped table-hover mt-2">
      <thead>
        <tr>
          <th>EmpNum</th>
          <th>EmpName</th>
          <th>Salary</th>
          <th>Department No</th>
        </tr>
      </thead>
      <tbody>
        <?php foreach ($answer4 as $item) : ?>
          <tr>
            <td><?php echo $item['no'] ?></td>
            <td><?php echo $item['name'] ?></td>
            <td><?php echo $item['salary'] ?></td>
            <td><?php echo $item['dep_no'] ?></td>
          </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
  </div>

  <div class="row p-4 align-items-center rounded-3 border shadow-lg mt-5">
    <h4 class="text-body-emphasis">จงเขียน SQL Command เพื่อแสดงจำนวนเงินเดือนรวมของแต่ละรหัสแผนก โดยรหัสแผนกใดไม่มีพนักงานสังกัดอยู่ไม่ต้องแสดงข้อมูลของรหัสแผนกนั้นๆ</h4>
    <p>
      SELECT d.`no`, d.`name`, SUM(e.`salary`) AS sum_salary <br />
      FROM `department` AS d <br />
      LEFT JOIN `employee` AS e <br />
      ON e.`dep_no` = d.`no` <br />
      GROUP BY d.`no` <br />
      HAVING COUNT(e.`no`) > 0
    </p>
    <table class="table table-dark table-bordered table-striped table-hover mt-2">
      <thead>
        <tr>
          <th>Department No</th>
          <th>Department Name</th>
          <th>Summary Salary</th>
        </tr>
      </thead>
      <tbody>
        <?php foreach ($answer5 as $item) : ?>
          <tr>
            <td><?php echo $item['no'] ?></td>
            <td><?php echo $item['name'] ?></td>
            <td><?php echo $item['sum_salary'] ?></td>
          </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
  </div>

  <div class="row p-4 align-items-center rounded-3 border shadow-lg mt-5">
    <h4 class="text-body-emphasis"> จงเขียน SQL Command เพื่อแสดงจำนวนพนักงานที่อยู่ในแผนก Accounting (สมมติว่าไม่ทราบรหัสแผนกของแผนก Accounting)</h4>
    <p>
      SELECT d.`no`, d.`name`, COUNT(e.`no`) AS num_employee <br />
      FROM `department` AS d <br />
      LEFT JOIN `employee` AS e <br />
      ON e.`dep_no` = d.`no` <br />
      WHERE d.`name` = "Accounting" <br />
      GROUP BY d.`no` <br />
    </p>
    <table class="table table-dark table-bordered table-striped table-hover mt-2">
      <thead>
        <tr>
          <th>Department No</th>
          <th>Department Name</th>
          <th>Total Employee</th>
        </tr>
      </thead>
      <tbody>
        <?php foreach ($answer6 as $item) : ?>
          <tr>
            <td><?php echo $item['no'] ?></td>
            <td><?php echo $item['name'] ?></td>
            <td><?php echo $item['num_employee'] ?></td>
          </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
  </div>

  <div class="row p-4 align-items-center rounded-3 border shadow-lg mt-5">
    <h4 class="text-body-emphasis">จงเขียน SQL Command ในการปรับเงินเดือนพนักงานเพิ่มขึ้น 1.5 เท่า</h4>
    <p>
      SELECT `no`, `name`, `salary`, (`salary` * 1.5) AS new_salary <br />
      FROM `employee` <br />
    </p>
    <table class="table table-dark table-bordered table-striped table-hover mt-2">
      <thead>
        <tr>
          <th>No</th>
          <th>Name</th>
          <th>Salary</th>
          <th>New Salary</th>
        </tr>
      </thead>
      <tbody>
        <?php foreach ($answer7 as $item) : ?>
          <tr>
            <td><?php echo $item['no'] ?></td>
            <td><?php echo $item['name'] ?></td>
            <td><?php echo $item['salary'] ?></td>
            <td><?php echo $item['new_salary'] ?></td>
          </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
  </div>
</div>

<?php layoutFooter() ?>