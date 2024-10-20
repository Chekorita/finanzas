package Clases;

public class Presupuesto {
	private int id;
	private String nombre;
	private float monto;
	private int id_tipo_gasto;
	private int estado;
	private int id_usuario;

	public Presupuesto() {}

	public Presupuesto(int id, String nombre, float monto, int id_tipo_gasto, int estado, int id_usuario) {
		this.id = id;
		this.nombre = nombre;
		this.monto = monto;
		this.id_tipo_gasto = id_tipo_gasto;
		this.estado = estado;
		this.id_usuario = id_usuario;
	}

	public int getId() {
		return id;
	}
	public void setId(int id) {
		this.id = id;
	}
	public String getNombre() {
		return nombre;
	}
	public void setNombre(String nombre) {
		this.nombre = nombre;
	}
	public float getMonto() {
		return monto;
	}
	public void setMonto(float monto) {
		this.monto = monto;
	}
	public int getId_tipo_gasto() {
		return id_tipo_gasto;
	}
	public void setId_tipo_gasto(int id_tipo_gasto) {
		this.id_tipo_gasto = id_tipo_gasto;
	}
	public int getEstado() {
		return estado;
	}
	public void setEstado(int estado) {
		this.estado = estado;
	}
	public int getId_usuario() {
		return id_usuario;
	}
	public void setId_usuario(int id_usuario) {
		this.id_usuario = id_usuario;
	}
}
