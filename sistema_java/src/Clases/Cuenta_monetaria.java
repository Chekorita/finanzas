package Clases;

public class Cuenta_monetaria {
	private int id;
	private String nombre;
	private float fondo;
	private int tipo;
	private int estado;
	private int id_usuario;

	public Cuenta_monetaria() {}

	public Cuenta_monetaria(int id, String nombre, float fondo, int tipo, int estado, int id_usuario) {
		super();
		this.id = id;
		this.nombre = nombre;
		this.fondo = fondo;
		this.tipo = tipo;
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
	public float getFondo() {
		return fondo;
	}
	public void setFondo(float fondo) {
		this.fondo = fondo;
	}
	public int getTipo() {
		return tipo;
	}
	public void setTipo(int tipo) {
		this.tipo = tipo;
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
