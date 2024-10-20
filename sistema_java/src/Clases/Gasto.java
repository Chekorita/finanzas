package Clases;

public class Gasto {
	private int id;
	private float monto;
	private String descripcion;
	private int id_tipo_gasto;
	private int id_persona;
	private int id_cuenta;
	private int id_usuario;

	public Gasto() {}

	public Gasto(int id, float monto, String descripcion, int id_tipo_gasto, int id_persona, int id_cuenta,
			int id_usuario) {
		super();
		this.id = id;
		this.monto = monto;
		this.descripcion = descripcion;
		this.id_tipo_gasto = id_tipo_gasto;
		this.id_persona = id_persona;
		this.id_cuenta = id_cuenta;
		this.id_usuario = id_usuario;
	}

	public int getId() {
		return id;
	}
	public void setId(int id) {
		this.id = id;
	}
	public float getMonto() {
		return monto;
	}
	public void setMonto(float monto) {
		this.monto = monto;
	}
	public String getDescripcion() {
		return descripcion;
	}
	public void setDescripcion(String descripcion) {
		this.descripcion = descripcion;
	}
	public int getId_tipo_ingreso() {
		return id_tipo_gasto;
	}
	public void setId_tipo_ingreso(int id_tipo_gasto) {
		this.id_tipo_gasto = id_tipo_gasto;
	}
	public int getId_persona() {
		return id_persona;
	}
	public void setId_persona(int id_persona) {
		this.id_persona = id_persona;
	}
	public int getId_cuenta() {
		return id_cuenta;
	}
	public void setId_cuenta(int id_cuenta) {
		this.id_cuenta = id_cuenta;
	}
	public int getId_usuario() {
		return id_usuario;
	}
	public void setId_usuario(int id_usuario) {
		this.id_usuario = id_usuario;
	}
}
