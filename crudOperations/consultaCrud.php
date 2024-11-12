<?php
require 'db.php';


function getAllConsultas()
{
  $pdo = getConnection();
  try {
    $sql = "select * from paciente";
    $stmt = $pdo->query($sql);

    $consultas = $stmt->fetchAll(PDO::FETCH_ASSOC);
    header('Content-Type: application/json');
    echo json_encode($consultas);
  } catch (PDOException $e) {
    echo "Erro na consulta" . $e->getMessage();
  }
}

function getConsultaById($id)
{
  $pdo = getConnection();
  try {
    $sql = "select * from paciente where id=:id";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':id', $id);
    $stmt->execute();

    $consulta = $stmt->fetchAll(PDO::FETCH_ASSOC);
    header('Content-Type: application/json');
    echo json_encode($consulta);
  } catch (PDOException $e) {
    echo "Erro na consulta" . $e->getMessage();
  }
}

function createConsulta($data)
{
  $pdo = getConnection();

  if (!$data['pacienteId']) {
    echo "Eh preciso passar o paciente";
    return;
  }

  if (!$data['medicoId']) {
    echo "Eh preciso passar o medico";
    return;
  }

  if (!$data['data']) {
    echo "Eh preciso passar a data da consulta";
    return;
  }

  $dataDaConsulta = new DateTime($data['data']);
  $diferenca = $dataDaConsulta->diff(new DateTime());

  if ($diferenca->h < 2) {
    echo "Eh preciso Marcar a consulta com antecedencia";
    return;
  }

  if ($diferenca->days > 2) {
    echo "Nao eh possivel marcar a consulta com mais de um dia de antecedencia";
    return;
  }
  $horas = $dataDaConsulta->format('H');
  if ($horas > 18) {
    echo "Nao eh possivel marcar a consulta para um horario alem das 18";
    return;
  }

  try {
    $sql = "INSERT INTO agendamentos(medicoId, pacienteId, dataConsulta) values(:medicoId, :pacienteId, :data)";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':medicoId', $data['medicoId']);
    $stmt->bindParam(':pacienteId', $data['pacienteId']);
    $stmt->bindParam(':data', $data['data']);

    if ($stmt->execute()) {
      echo json_encode(['message' => 'consulta criada criado']);
    } else {
      echo json_encode(['message' => 'Erro ao criar consulta']);
    }
  } catch (PDOException $e) {
    echo "Erro na consulta" . $e->getMessage();
  }
}

function deleteConsulta($id)
{
  $pdo = getConnection();
  try {
    $sql = "delete from agendamentos where id = :id";
    $stmt = $pdo->prepare($sql);

    if ($stmt->execute(['id' => $id])) {
      echo json_encode(['message' => 'agendamento excluido']);
    } else {
      echo json_encode(['message' => 'Erro ao excluir agendamento']);
    }
  } catch (PDOException $e) {
    echo "Erro na consulta" . $e->getMessage();
  }
}

function updateConsulta($data, $id)
{
  $pdo = getConnection();

  if (!$data['pacienteId']) {
    echo "Eh preciso passar o paciente";
    return;
  }

  if (!$data['medicoId']) {
    echo "Eh preciso passar o medico";
    return;
  }

  if (!$data['data']) {
    echo "Eh preciso passar a data da consulta";
    return;
  }

  $dataDaConsulta = new DateTime($data['data']);
  $diferenca = $dataDaConsulta->diff(new DateTime());

  if ($diferenca->h < 2) {
    echo "Eh preciso atualizar a consulta com antecedencia";
    return;
  }

  $horas = $dataDaConsulta->format('H');
  if ($horas > 18) {
    echo "Nao eh possivel atualizar a consulta para um horario alem das 18";
    return;
  }

  try {
    $sql = "UPDATE agendamentos set pacienteId=:pacienteId, medicoId=:medicoId, dataConsulta=:data where id=:id";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':pacienteId', $data['pacienteId']);
    $stmt->bindParam(':medicoId', $data['medicoId']);
    $stmt->bindParam(':data', $data['data']);
    $stmt->bindParam(':id', $id);

    if ($stmt->execute()) {
      echo json_encode(['message' => 'consulta atualizado']);
    } else {
      echo json_encode(['message' => 'Erro ao atualizar consulta']);
    }
  } catch (PDOException $e) {
    echo "Erro na consulta" . $e->getMessage();
  }
}
